@extends('layouts.base', ["current" => "categorias"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <h5 class = "card-title"> Clientes </h5>
        @if(count($clientes) > 0)
        <table class = "table table-ordered table hover">
            <thead>
                <th> Código </th>
                <th> Nome </th>
                <th> Ações </th>
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                <tr>
                    <td>{{$cliente->id}}</td>
                    <td>{{$cliente->nome}}</td>
                    <td>
                        <a href = "/clientes/editar/{{$cliente->id}}" class = "btn btn-sm btn-primary"> Editar </a>
                        <a href = "/clientes/apagar/{{$cliente->id}}" class = "btn btn-sm btn-danger"> Apagar </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div class = "card-footer">
        <a href = "/clientes/novo" class = "btn btn-sm btn-primary" role = "button"> Novo cliente </a>
</div>
@endsection