@extends('layouts.baseAt', ["current" => "clientes"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <h5 class = "card-title"> Clientes </h5>
        @if(count($clientes) > 0)
        <table class = "table table-ordered table hover">
            <thead>
                <th> Código </th>
                <th> Nome </th>
                @if(Auth::user()->admin == 1)
                    <th> Ações </th>
                @endif
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                <tr>
                    <td>{{$cliente->id}}</td>
                    <td>{{$cliente->nome}}</td>
                    @if(Auth::user()->admin == 1)
                        <td>
                            <a href = "/clientes/editar/{{$cliente->id}}" class = "btn btn-sm btn-primary"> Editar </a>
                            <a href = "/clientes/apagar/{{$cliente->id}}" class = "btn btn-sm btn-danger"> Apagar </a>
                        </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div class = "card-footer">
        @if(Auth::user()->admin == 1)
            <a href = "/clientes/novo" class = "btn btn-sm btn-primary" role = "button"> Novo cliente </a>
            <a href = "/clientes/download" class = "btn btn-sm btn-info" role = "button"> Baixar planilha </a>
        @endif
    </div>
    
</div>
@endsection