@extends('layouts.base', ["current" => "Alocar usuário"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <form action = "/tarefausuario" method="POST">
            @csrf
            <input type="hidden" id="idProjeto" name="idProjeto" value="{{$projeto->id}}">
            <input type="hidden" id="idTarefa" name="idTarefa" value="{{$tarefa->id}}">
            <div class = "form-group">
                <label for = "nomeTarefa"> Nome da tarefa </label>
                <input type = "text" class = "form-control" name = "nomeTarefa" id = "nomeTarefa"  value = "{{$tarefa->nome}}" readonly>
            </div>
            <div class = "form-group">
                <label for = "nomeProjeto"> Nome do projeto </label>
                <input type = "text" class = "form-control" name = "nomeProjeto" id = "nomeProjeto"  value = "{{$projeto->nome}}" readonly>
            </div>
            <div class="form-group">
                <label for="usuario">Usuário</label>
                <select class="form-control" id="usuario" name = "usuario">
                  @foreach($usuarios as $usuario) 
                    <option value = {{$usuario->user_id}}>{{$usuario->nomeUsuario}}</option>
                  @endforeach
                </select>
            </div>
            
            <button type = "submit" class = "btn btn-primary btn-sm"> Alocar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm"> Cancelar </button>
        </form>
    </div>
</div>
@endsection