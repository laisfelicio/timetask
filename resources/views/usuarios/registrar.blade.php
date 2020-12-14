@extends('layouts.baseAt', ["current" => "usuarios", "titulo" => "Usuários"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Registrar usuário</h4>
        </div>
    </div>
    <div class = "card-body">
        <form action = "/usuarios" method="POST">
            @csrf
            <div class = "form-group">
                <label for = "nomeUsuario"> Nome do usuario </label>
                <input type = "text" class = "form-control" name = "nomeUsuario" id = "nomeUsuario" value = "{{old('nomeUsuario')}}">
            
                @error('nomeUsuario')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>   
            <div class = "form-group">
                <label for = "emailUsuario"> E-mail </label>
                <input type = "email" class = "form-control" name = "emailUsuario" id = "emailUsuario" value = "{{old('emailUsuario')}}">
            
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
            <button type = "submit" class = "btn btn-primary btn-sm btn-round"> Salvar </button>
            <a class = "btn btn-danger btn-sm btn-round" href = "{{url()->previous()}}"> Cancelar </a>
        </form>
    </div>
</div>
@endsection