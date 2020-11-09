@extends('layouts.baseAt', ["current" => "tarefas", "titulo" => "Tarefas"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Tarefas</h4>
        </div>
    </div>
    <div class = "card-body">
        @if(count($tarefas) > 0)
        <p>
            <button class="btn btn-primary btn-round" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              OPÇÕES DE FILTRO
            </button>
        </p>
        <div class="collapse" id="collapseExample">
            <div class = "card">
                <div class = "card-body">
                    <form method = "GET" action = "/tarefas">
                        <div class="form-group">
                            <label for="statusTarefa">Status</label>
                            <select class="form-control" id="statusTarefa" name = "statusTarefa">
                            @foreach($statusTarefas as $status) 
                                <option value = {{$status->id}}>{{$status->nome}}</option>
                            @endforeach
                                <option value = "">TODOS</option>
                            </select>
                        </div>
        
                        <div class="form-group">
                            <label for="projeto">Projeto</label>
                            <select class="form-control" id="projeto" name = "projeto">
                            <option value = "">TODOS</option>
                            @foreach($projetos as $projeto) 
                                <option value = {{$projeto->id}}>{{$projeto->nome}}</option>
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
                <th> Projeto </th>
                <th> Status </th>
                <th> Ações </th>
                <th> </th>
            </thead>
            <tbody>
                @foreach($tarefas as $tarefa)
                <tr>
                    <td>{{$tarefa->id}}</td>
                    <td>{{$tarefa->nome}}</td>
                    <td>{{$tarefa->projeto->nome}}</td>
                    <td>{{$tarefa->status->nome}}</td>
                    <td>
                        <a href = "/tarefas/editar/{{$tarefa->id}}" class = "btn btn-sm btn-primary btn-round"> Editar </a>
                        <a href = "/tarefausuario/{{$tarefa->projeto_id}}/{{$tarefa->id}}" class = "btn btn-sm btn-primary btn-round"> Alocar usuário </a>
                        <a href = "/tarefausuario/info/{{$tarefa->projeto_id}}/{{$tarefa->id}}" class = "btn btn-sm btn-primary btn-round"> + Info </a>
                        <a href = "/tarefas/apagar/{{$tarefa->id}}" class = "btn btn-sm btn-danger btn-round"> Apagar </a>
                    </td>
                    <td>
                        
                        @if($dataAtual > $tarefa->data_prevista && $tarefa->status_id != 4)
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
        <a href = "/tarefas/novo" class = "btn btn-sm btn-primary" role = "button"> Nova Tarefa </a>
        <form method = "POST" action="{{ route('tarefas.download') }}" >
            @csrf
            <input type = "hidden" name = "tarefas" value='<?= $tarefas ?>'></input>
            <button type = "submit" class = "btn btn-info btn-sm"> Download Relatório</button>
        </form>
    </div>
</div>
@endsection