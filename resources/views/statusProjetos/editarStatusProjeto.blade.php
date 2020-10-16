@extends('layouts.baseAt', ["current" => "categorias"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <form action = "/statusprojeto/{{$status->id}}" method="POST">
            @csrf
            <div class = "form-group">
                <label for = "nomeStatus"> Nome da Categoria </label>
                <input type = "text" class = "form-control" name = "nomeStatus" id = "nomeStatus" value = "{{$status->nome}}">
            </div>
            <button type = "submit" class = "btn btn-primary btn-sm"> Salvar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm"> Cancelar </button>
        </form>
    </div>
</div>
@endsection