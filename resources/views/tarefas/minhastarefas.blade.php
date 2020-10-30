@extends('layouts.baseAt', ["current" => "tarefas"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <h5 class = "card-title"> Tarefas </h5>
        
        @if(count($tarefas) > 0)
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
                    <td>{{$tarefa->tarefa_id}}</td>
                    <td>{{$tarefa->nomeTarefa}}</td>
                    <td>{{$tarefa->nomeProjeto}}</td>
                    <td>{{$tarefa->statusTarefa}}</td>
                    <td>
                        <a href = "/tarefas/editar/{{$tarefa->tarefa_id}}" class ="btn btn-sm btn-primary"> Editar </a>
                        <a href = "/tarefausuario/{{$tarefa->idProjeto}}/{{$tarefa->tarefa_id}}" class = "btn btn-sm btn-primary"> Alocar usuário </a>
                        <a href = "/gerenciarTarefa/{{$tarefa->tarefa_id}}" class = "btn btn-sm btn-primary"> <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
                          </svg> </a>
                        <a href = "/tarefas/apagar/{{$tarefa->id}}" class = "btn btn-sm btn-danger"> Apagar </a>
                          
                    </td>
                    <td>
                        
                        @if($dataAtual > $tarefa->dataPrevista && $tarefa->status_id != 4)
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
</div>
</div>
@endsection