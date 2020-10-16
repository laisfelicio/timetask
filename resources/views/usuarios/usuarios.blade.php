@extends('layouts.baseAt', ["current" => "usuarios"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <h5 class = "card-title"> Usuários </h5>
        @if(count($usuarios) > 0)
        <table class = "table table-ordered table hover">
            <thead>
                <th> Código </th>
                <th> Nome </th>
                <th> Email </th>
                <th> Ações </th>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                <tr>
                    <td>{{$usuario->id}}</td>
                    <td>{{$usuario->name}}</td>
                    <td>{{$usuario->email}}</td>
                    <td>
                        <a href = "/usuarios/editar/{{$usuario->id}}" class = "btn btn-sm btn-primary"> Editar </a>
                        <a href = "/usuarios/apagar/{{$usuario->id}}" class = "btn btn-sm btn-danger"> Apagar </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div class = "card-footer">
        <a href = "/usuarios/registrar" class = "btn btn-sm btn-primary" role = "button"> Novo Usuário </a>
</div>
@endsection