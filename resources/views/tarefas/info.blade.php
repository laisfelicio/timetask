@extends('layouts.base', ["current" => "Projetos"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <h5 class = "card-title"> Usuários Alocados </h5>
        @if(count($alocados) > 0)
        <div class = "form-group">
            <label for = "nomeTarefa"> Nome da tarefa </label>
            <input type = "text" class = "form-control" name = "nomeTarefa" id = "nomeTarefa"  value = "{{$tarefa->nome}}" readonly>
        </div>
        <div class = "form-group">
            <label for = "nomeProjeto"> Nome do Projeto </label>
            <input type = "text" class = "form-control" name = "nomeProjeto" id = "nomeProjeto"  value = "{{$projeto->nome}}" readonly>
        </div>
        <table class = "table table-ordered table hover">
            <thead>
                <th> Código Usuário</th>
                <th> Nome </th>
                <th> Email </th>
                <th> Ações </th>
            </thead>
            <tbody>
                @foreach($alocados as $usu)
                <tr>
                    <td>{{$usu->idUsuario}}</td>
                    <td>{{$usu->nomeUsuario}}</td>
                    <td>{{$usu->emailUsuario}}</td>
                    <td>
                        <a href = "/tarefausuario/apagar/alocacao/{{$usu->id}}" class = "btn btn-sm btn-danger"> Desalocar </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div class = "card-footer">
        <a href = "/tarefausuario/{{$projeto->id}}/{{$tarefa->id}}" class = "btn btn-sm btn-primary" role = "button"> Alocar novos usuários </a>
</div>
@endsection