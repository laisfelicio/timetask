@extends('layouts.baseAt', ["current" => "tarefas", "titulo" => "Tarefas"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Nova tarefa</h4>
        </div>
    </div>
    <div class = "card-body">
        <form action = "/tarefas" method="POST">
            @csrf
            <div class = "form-group">
                <label for = "nomeTarefa"> Nome da tarefa </label>
                <input type = "text" class = "form-control" name = "nomeTarefa" id = "nomeTarefa" value = "{{old('nomeTarefa')}}">
            
                @error('nomeTarefa')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>
            <div class = "form-group">
                <label for = "descTarefa"> Descrição </label>
                <input type = "text" class = "form-control" name = "descTarefa" id = "descTarefa" value = "{{old('descTarefa')}}">
            
                @error('descTarefa')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>
            <div class="form-group">
                <label for="projeto">Projeto</label>
                <select class="form-control" id="projeto" name = "projeto">
                  @foreach($projetos as $projeto) 
                    <option value = {{$projeto->id}}>{{$projeto->nome}}</option>
                  @endforeach
                </select>
            </div>
            <div class = "form-group">
                <label for = "tempoPrevisto"> Tempo estimado </label>
                <div id = "tempoPrevisto">
                    <input type="number" name = "horaPrevista" min="0" step="1" />:<input type="number" name = "minPrevisto" min="0" max="59" step="1" />: <input type="number" name = "secPrevisto" min="0" max="59" step="1" />
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
                <input type = "date" class = "form-control" name = "dataPrevista" id = "dataPrevista" value = "{{old('dataPrevista')}}">
            
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