@extends('layouts.baseAt', ["current" => "usuarios"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <h5> Registrar usuário </h5>
        <form action = "/usuarios" method="POST">
            @csrf
            <div class = "form-group">
                <label for = "nomeUsuario"> Nome do usuario </label>
                <input type = "text" class = "form-control" name = "nomeUsuario" id = "nomeUsuario">
            
                @error('nomeUsuario')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>   
            <div class = "form-group">
                <label for = "emailUsuario"> E-mail </label>
                <input type = "email" class = "form-control" name = "emailUsuario" id = "emailUsuario">
            
                @error('emailUsuario')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div> 

            <div class = "form-group">
                <label for = "senhaUsuario"> Senha </label>
                <input type = "password" class = "form-control" name = "senhaUsuario" id = "senhaUsuario">
            
                @error('senhaUsuario')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>  
            <div class = "form-group">
                <input type="checkbox" name="admin" value="sim"> <label>Administrador</label>
            </div>
            <button type = "submit" class = "btn btn-primary btn-sm"> Salvar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm"> Cancelar </button>
        </form>
    </div>
</div>
@endsection