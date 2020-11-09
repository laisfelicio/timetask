@extends('layouts.baseAt', ["current" => "tarefas", "titulo" => "Tarefas"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Minhas tarefas</h4>
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
                    <form method = "GET" action = "/tarefausuario/minhastarefas">
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
                        <a href = "/tarefas/editar/{{$tarefa->id}}" class ="btn btn-sm btn-primary btn-round"> Editar </a>
                        <a href = "/tarefausuario/{{$tarefa->projeto->id}}/{{$tarefa->id}}" class = "btn btn-sm btn-primary btn-round"> Alocar usuário </a>
                        <a href = "/gerenciarTarefa/{{$tarefa->id}}" class = "btn btn-sm btn-primary btn-round"> <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
                          </svg> </a>
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
        <a href = "/tarefas/novo" class = "btn btn-sm btn-primary btn-round" role = "button"> Nova Tarefa </a>
        <form method = "POST" action="{{ route('minhastarefas.download') }}" >
            @csrf
            <input type = "hidden" name = "tarefas" value='<?= $tarefas ?>'></input>
            <button type = "submit" class = "btn btn-info btn-sm"> Download Relatório</button>
        </form>
    </div>
</div>
@endsection