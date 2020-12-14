@extends('layouts.baseAt', ["current" => "perfil", "titulo" => "Perfil"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Editar usuário</h4>
        </div>
    </div>
    <div class = "card-body">
        <form action = "/usuarios/{{$usuario->id}}" method="POST">
            @csrf
            <div class = "form-group">
                <label for = "nomeUsuario"> Nome do usuario </label>
                <input type = "text" class = "form-control" name = "nomeUsuario" id = "nomeUsuario" value = "{{$usuario->name}}">
                @error('nomeUsuario')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>   
            <div class = "form-group">
                <label for = "emailUsuario"> E-mail </label>
                <input type = "email" class = "form-control" name = "emailUsuario" id = "emailUsuario" value = "{{$usuario->email}}">
                @error('emailUsuario')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>  
            <div class = "form-group">
                <label for = "senhaUsuario"> Senha </label>
                <input type = "password" class = "form-control" name = "senhaUsuario" id = "senhaUsuario" value = "{{$usuario->password}}">
                @error('senhaUsuario')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>  
            <button type = "submit" class = "btn btn-primary btn-sm btn-round"> Salvar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm btn-round"> Cancelar </button>
        </form>
    </div>
</div>
@endsection