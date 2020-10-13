@extends('layouts.base', ["current" => "Tarefas"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <h5 class = "card-title"> Meus Projetos </h5>
        @if(count($projetos) > 0)
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
                    <td>{{$projeto->nomeProjeto}}</td>
                    <td>{{$projeto->clienteProjeto}}</td>
                    <td>{{$projeto->statusProjeto}}</td>
                    <td>
                        <a href = "/projetos/editar/{{$projeto->id}}" class = "btn btn-sm btn-primary"> Editar </a>
                        <a href = "/projetousuario/alocar/{{$projeto->id}}" class = "btn btn-sm btn-primary"> Alocar usuário </a>
                        <a href = "/projetousuario/info/{{$projeto->id}}" class = "btn btn-sm btn-primary"> + Info </a>
                        @if(Auth::user()->admin == 1)
                             <a href = "/projetos/apagar/{{$projeto->id}}" class = "btn btn-sm btn-danger"> Apagar </a>
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
 </div>
@endsection