@extends('layouts.baseAt', ["current" => "tarefas"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <form action = "/tarefas/{{$tarefa->id}}" method="POST">
            @csrf
            <div class = "form-group">
                <label for = "nomeTarefa"> Nome da tarefa </label>
                <input type = "text" class = "form-control" name = "nomeTarefa" id = "nomeTarefa"  value = "{{$tarefa->nome}}">
            </div>
            <div class = "form-group">
                <label for = "descTarefa"> Descrição da tarefa </label>
                <input type = "text" class = "form-control" name = "descTarefa" id = "descTarefa" value = "{{$tarefa->descricao}}">
            </div>
            <div class="form-group">
                <label for="projeto">Projeto</label>
                <select class="form-control" id="projeto" name = "projeto">
                  @foreach($projetos as $projeto) 
                    @if($projeto->id == $tarefa->projeto_id)
                        <option value = {{$projeto->id}} selected>{{$projeto->nome}}</option>
                    @else
                        <option value = {{$projeto->id}}>{{$projeto->nome}}</option>
                    @endif
                  @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name = "status">
                  @foreach($statusTarefas as $status) 
                    @if($status->id == $projeto->status_id)
                        <option value = {{$status->id}} selected>{{$status->nome}}</option>
                    @else
                        <option value = {{$status->id}}>{{$status->nome}}</option>
                    @endif
                  @endforeach
                </select>
            </div>
            <div class = "form-group">
                <label for = "tempoPrevisto"> Tempo estimado </label>
                <input type = "text" class = "form-control" name = "tempoPrevisto" id = "tempoPrevisto" value = "{{$tarefa->tempo_previsto}}">
            </div>
            <button type = "submit" class = "btn btn-primary btn-sm"> Salvar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm"> Cancelar </button>
        </form>
    </div>
</div>
@endsection