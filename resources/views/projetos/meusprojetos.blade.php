@extends('layouts.baseAt', ["current" => "projetos"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <h5 class = "card-title"> Meus Projetos </h5>
        @if(count($projetos) > 0)
        <p>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
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
        
                        <button type = "submit" class = "btn btn-primary btn-sm"> Filtrar </button>
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
                    <td>{{$projeto->cliente}}</td>
                    <td>{{$projeto->status}}</td>
                    <td>
                        @if(Auth::user()->admin == 1)
                            <a href = "/projetos/editar/{{$projeto->projeto_id}}" class = "btn btn-sm btn-primary"> Editar </a>
                        @endif
                         <a href = "/projetousuario/alocar/{{$projeto->projeto_id}}" class = "btn btn-sm btn-primary"> Alocar usuário </a>
                        <a href = "/projetousuario/info/{{$projeto->projeto_id}}" class = "btn btn-sm btn-primary"> + Info </a>
                        @if(Auth::user()->admin == 1)
                             <a href = "/projetos/apagar/{{$projeto->projeto_id}}" class = "btn btn-sm btn-danger"> Apagar </a>
                        @endif
                    </td>
                    <td>
                        
                        @if($dataAtual > $projeto->dataPrevistaProjeto && $projeto->statusProjeto != 4)
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
@endsection