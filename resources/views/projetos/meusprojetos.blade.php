@extends('layouts.baseAt', ["current" => "projetos", "titulo" => "Projetos"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Meus projetos</h4>
        </div>
    </div>
    <div class = "card-body">
        @if(count($projetos) > 0)
        <p>
            <button class="btn btn-primary btn-round" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              OPÇÕES DE FILTRO
            </button>
        </p>
        <div class="collapse" id="collapseExample">
            <div class = "card">
                <div class = "card-body">
                    <form method = "GET" action = "/projetousuario/meusprojetos">
                        <div class="form-group">
                            <label for="statusProjeto">Status</label>
                            <select class="form-control" id="statusProjeto" name = "statusProjeto">
                                <option value = "">TODOS</option>
                                @foreach($statusProjetos as $status) 
                                <option value = {{$status->id}}>{{$status->nome}}</option>
                            @endforeach
                            </select>
                        </div>
        
                        <div class="form-group">
                            <label for="clienteProjeto">Cliente</label>
                            <select class="form-control" id="clienteProjeto" name = "clienteProjeto">
                            <option value = "">TODOS</option>
                            @foreach($clientes as $cliente) 
                                <option value = {{$cliente->id}}>{{$cliente->nome}}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="atraso">Em atraso?</label>
                            <select class="form-control" id="atraso" name = "atraso">
                                <option value = "">Todos</option>
                                <option value = "SIM">Sim</option>
                                <option value = "NAO">Não</option>
                            </select>
                        </div>
        
                        <button type = "submit" class = "btn btn-primary btn-sm btn-round"> Filtrar </button>
                    </form>
                </div>
            </div>
        </div>
        <table class = "table table-ordered table hover">
            <thead>
                <th> Código </th>
                <th> Nome </th>
                <th> Cliente </th>
                <th> Status </th>
                <th> Ações </th>
            </thead>
            <tbody>
                @foreach($projetos as $projeto)
                <tr>
                    <td>{{$projeto->id}}</td>
                    <td>{{$projeto->nome}}</td>
                    <td>{{$projeto->cliente->nome}}</td>
                    <td>{{$projeto->status->nome}}</td>
                    <td>
                        @if(Auth::user()->admin == 1)
                            <a href = "/projetos/editar/{{$projeto->id}}" class = "btn btn-sm btn-primary btn-round"> Editar </a>
                            <a href = "/projetousuario/alocar/{{$projeto->id}}" class = "btn btn-sm btn-primary btn-round"> Alocar usuário </a>
                        @endif
                        <a href = "/projetousuario/info/{{$projeto->id}}" class = "btn btn-sm btn-primary btn-round"> + Info </a>
                        @if(Auth::user()->admin == 1)
                             <a href = "/projetos/apagar/{{$projeto->id}}" class = "btn btn-sm btn-danger btn-round"> Apagar </a>
                        @endif
                    </td>
                    <td>
                        
                        @if($dataAtual > $projeto->data_prevista && $projeto->status_id != 4)
                            <i class="material-icons" style = "color: #ff0000;">warning</i>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div class = "card-footer">
        @if(Auth::user()->admin == 1)
            <a href = "/projetos/novo" class = "btn btn-sm btn-primary" role = "button"> Novo Projeto </a>
        @endif
        <form method = "POST" action="{{ route('meusprojetos.download') }}" >
            @csrf
            <input type = "hidden" name = "projetos" value='<?= $projetos ?>'></input>
            <button type = "submit" class = "btn btn-info btn-sm"> Download Relatório</button>
        </form>
 </div>
</div>
@endsection