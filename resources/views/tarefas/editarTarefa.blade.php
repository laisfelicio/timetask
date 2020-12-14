@extends('layouts.baseAt', ["current" => "tarefas", "titulo" => "Tarefas"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Editar tarefa</h4>
        </div>
    </div>
    <div class = "card-body">
        <form action = "/tarefas/{{$tarefa->id}}" method="POST">
            @csrf
            <div class = "form-group">
                <label for = "nomeTarefa"> Nome da tarefa </label>
                <input type = "text" class = "form-control" name = "nomeTarefa" id = "nomeTarefa"  value = "{{$tarefa->nome}}">
            
                @error('nomeTarefa')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>
            <div class = "form-group">
                <label for = "descTarefa"> Descrição da tarefa </label>
                <input type = "text" class = "form-control" name = "descTarefa" id = "descTarefa" value = "{{$tarefa->descricao}}">
           
                @error('descTarefa')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>
            <div class="form-group">
                <input type="hidden" id="projeto" name="projeto" value="{{$tarefa->projeto_id}}">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name = "status">
                  @foreach($statusTarefas as $status) 
                    @if($status->id == $tarefa->status_id)
                        <option value = {{$status->id}} selected>{{$status->nome}}</option>
                    @else
                        <option value = {{$status->id}}>{{$status->nome}}</option>
                    @endif
                  @endforeach
                </select>
                @error('status')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>
            <div class = "form-group">
                <label for = "tempoPrevisto"> Tempo estimado </label>
                <div id = "tempoPrevisto">
                    
                    <input type="number" value = {{$temp[0]}} name = "horaPrevista" min="0" step="1" />:
                    <input type="number" value = {{$temp[1]}} name = "minPrevisto" min="0" max="59" step="1" />: 
                    <input type="number" value = {{$temp[2]}} name = "secPrevisto" min="0" max="59" step="1" />
                    @error('horaPrevista')
                        <p class = "text-danger"> {{$message}} </p>
                    @enderror
                    @error('minPrevisto')
                        <p class = "text-danger"> {{$message}} </p>
                    @enderror
                    @error('secPrevisto')
                        <p class = "text-danger"> {{$message}} </p>
                    @enderror
                </div>
            </div>
            <div class = "form-group">
                <label for = "dataPrevista"> Data prevista de entrega </label>
                <input type = "date" class = "form-control" name = "dataPrevista" id = "dataPrevista" value = "{{$tarefa->data_prevista}}">
            
                @error('dataPrevista')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>
            <button type = "submit" class = "btn btn-primary btn-sm btn-round"> Salvar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm btn-round"> Cancelar </button>
        </form>
    </div>
</div>
@endsection