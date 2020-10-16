@extends('layouts.baseAt', ["current" => "categorias"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <form action = "/statusprojeto" method="POST">
            @csrf
            <div class = "form-group">
                <label for = "nomeStatus"> Nome do status </label>
                <input type = "text" class = "form-control" name = "nomeStatus" id = "nomeStatus" placeHolder = "Nome do status">
            </div>
            <button type = "submit" class = "btn btn-primary btn-sm"> Salvar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm"> Cancelar </button>
        </form>
    </div>
</div>
@endsection