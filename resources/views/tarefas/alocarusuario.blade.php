@extends('layouts.baseAt', ["current" => "tarefas", "titulo" => "Tarefas - Alocar usuário"])

@section('body')

<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Alocar usuário</h4>
        </div>
    </div>
    <div class = "card-body">
        <form action = "/tarefausuario" method="POST">
            @csrf
            <input type="hidden" id="idProjeto" name="idProjeto" value="{{$projeto->id}}">
            <input type="hidden" id="idTarefa" name="idTarefa" value="{{$tarefa->id}}">
            <div class = "form-group">
                <label for = "nomeTarefa"> Nome da tarefa </label><br>
                <input type = "text" class = "form-control" name = "nomeTarefa" id = "nomeTarefa"  value = "{{$tarefa->nome}}" readonly>
                @error('idTarefa')
                    <p class = "text-danger">{{$message}}</p>
                @enderror
            </div>

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
            </div>
            @error('usuario')
                <p class = "text-danger">{{$message}}</p>
            @enderror
            
            <button type = "submit" class = "btn btn-primary btn-sm btn-round"> Alocar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm btn-round"> Cancelar </button>
        </form>

    </div>
</div>
@endsection