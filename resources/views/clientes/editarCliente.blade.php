@extends('layouts.baseAt', ["current" => "clientes"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <form action = "/clientes/{{$cli->id}}" method="POST">
            @csrf
            <div class = "form-group">
                <label for = "nomeCliente"> Nome da Categoria </label>
                <input type = "text" class = "form-control" name = "nomeCliente" id = "nomeCliente" placeHolder = "Cliente" value = "{{$cli->nome}}">
            </div>
            <button type = "submit" class = "btn btn-primary btn-sm"> Salvar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm"> Cancelar </button>
        </form>
    </div>
</div>
@endsection