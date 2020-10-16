@extends('layouts.baseAt', ["current" => "projetos"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <h5 class = "card-title"> Projetos </h5>
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
                @foreach($projetos as $proj)
                <tr>
                    <td>{{$proj->id}}</td>
                    <td>{{$proj->nome}}</td>
                    <td>{{$proj->cliente}}</td>
                    <td>{{$proj->status}}</td>
                    <td>
                        <a href = "/projetos/editar/{{$proj->id}}" class = "btn btn-sm btn-primary"> Editar </a>
                        <a href = "/projetousuario/alocar/{{$proj->id}}" class = "btn btn-sm btn-primary"> Alocar usuário </a>
                        <a href = "/projetousuario/info/{{$proj->id}}" class = "btn btn-sm btn-primary"> + Info </a>
                        <a href = "/projetos/apagar/{{$proj->id}}" class = "btn btn-sm btn-danger"> Apagar </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div class = "card-footer">
        <a href = "/projetos/novo" class = "btn btn-sm btn-primary" role = "button"> Novo Projeto </a>
    </div>
</div>
@endsection