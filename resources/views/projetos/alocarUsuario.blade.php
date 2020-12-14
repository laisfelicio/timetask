@extends('layouts.baseAt', ["current" => "projetos", "titulo" => "Projeto - Usuários"])

@section('body')


<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Alocar usuário</h4>
        </div>
    </div>
    <div class = "card-body">
        <form action = "/projetousuario" method="POST">
            @csrf
            <input type="hidden" id="idProjeto" name="idProjeto" value="{{$projeto->id}}">
            <div class = "form-group">
                <label for = "nomeProjeto"> Nome do projeto </label><br>
                <input type = "text" class = "form-control" name = "nomeProjeto" id = "nomeProjeto"  value = "{{$projeto->nome}}" readonly>
                @error('idProjeto')
                    <p class = "text-danger">{{$message}}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="usuario">Usuário</label><br>
                <select class="form-control" id="usuario" name = "usuario">
                  @foreach($usuarios as $usuario) 
                    <option value = {{$usuario->id}}>{{$usuario->name}}</option>
                  @endforeach
                </select>

                @error('usuario')
                    <p class = "text-danger">{{$message}}</p>
                @enderror
            </div>
            
            <button type = "submit" class = "btn btn-primary btn-sm btn-round"> Alocar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm btn-round"> Cancelar </button>
        </form>
    </div>
</div>

@endsection