@extends('layouts.base', ["current" => "Editar Tarefa"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <form action = "/usuarios/{{$usuario->id}}" method="POST">
            @csrf
            <div class = "form-group">
                <label for = "nomeUsuario"> Nome do usuario </label>
                <input type = "text" class = "form-control" name = "nomeUsuario" id = "nomeUsuario" value = {{$usuario->name}}>
            </div>   
            <div class = "form-group">
                <label for = "emailUsuario"> E-mail </label>
                <input type = "email" class = "form-control" name = "emailUsuario" id = "emailUsuario" value = {{$usuario->email}}>
            </div>  
            <div class = "form-group">
                <label for = "senhaUsuario"> Senha </label>
                <input type = "password" class = "form-control" name = "senhaUsuario" id = "senhaUsuario" value = {{$usuario->password}}>
            </div>  
            <button type = "submit" class = "btn btn-primary btn-sm"> Salvar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm"> Cancelar </button>
        </form>
    </div>
</div>
@endsection