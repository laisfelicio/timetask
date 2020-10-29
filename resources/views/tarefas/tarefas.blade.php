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
                    <td>{{$tarefa->id}}</td>
                    <td>{{$tarefa->nome}}</td>
                    <td>{{$tarefa->projeto}}</td>
                    <td>{{$tarefa->status}}</td>
                    <td>
                        <a href = "/tarefas/editar/{{$tarefa->id}}" class = "btn btn-sm btn-primary"> Editar </a>
                        <a href = "/tarefausuario/{{$tarefa->projeto_id}}/{{$tarefa->id}}" class = "btn btn-sm btn-primary"> Alocar usuário </a>
                        <a href = "/tarefausuario/info/{{$tarefa->projeto_id}}/{{$tarefa->id}}" class = "btn btn-sm btn-primary"> + Info </a>
                        <a href = "/tarefas/apagar/{{$tarefa->id}}" class = "btn btn-sm btn-danger"> Apagar </a>
                    </td>
                    <td>
                        
                        @if($dataAtual > $tarefa->data_prevista)
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