@extends('layouts.baseAt', ["current" => "projetos"])

@section('body')

<div class = "card border">
    <div class = "card-body">
        <h5 class = "card-title"> Projetos </h5>
        @if(count($projetos) > 0)

        <p>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              OPÇÕES DE FILTRO
            </button>
        </p>
        <div class="collapse" id="collapseExample">
            <div class = "card">
                <div class = "card-body">
                    <form method = "GET" action = "/projetos">
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
                <th> </th>
            </thead>
            <tbody>
                @foreach($projetos as $proj)
                <tr>
                    <td>{{$proj->id}}</td>
                    <td>{{$proj->nome}}</td>
                    <td>{{$proj->cliente}}</td>
                    <td>{{$proj->status}}</td>
                    <td>
                        @if(Auth::user()->admin == 1)
                            <a href = "/projetos/editar/{{$proj->id}}" class = "btn btn-sm btn-primary"> Editar </a>
                        @endif
                        <a href = "/projetousuario/alocar/{{$proj->id}}" class = "btn btn-sm btn-primary"> Alocar usuário </a>
                        <a href = "/projetousuario/info/{{$proj->id}}" class = "btn btn-sm btn-primary"> + Info </a>
                        @if(Auth::user()->admin == 1)
                            <a href = "/projetos/apagar/{{$proj->id}}" class = "btn btn-sm btn-danger"> Apagar </a>
                        @endif
                    </td>
                    <td>
                        
                        @if($dataAtual > $proj->data_prevista && $proj->status_id != 4)
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
        <form method = "POST" action="{{ route('projetos.download') }}" >
            @csrf
            <input type = "hidden" name = "projetos" value='<?= $projetos ?>'></input>
            <button type = "submit" class = "btn btn-info btn-sm"> Download Relatório</button>
        </form>
    </div>
</div>
@endsection