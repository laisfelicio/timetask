@extends('layouts.baseAt', ["current" => "tarefas"])

@section('body')
<div class = "card border">
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
                <input type = "time" class = "form-control" name = "tempoPrevisto" id = "tempoPrevisto" value = "{{old('tempoPrevisto')}}">
            
                @error('tempoPrevisto')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>
            <div class = "form-group">
                <label for = "dataPrevista"> Data prevista de entrega </label>
                <input type = "date" class = "form-control" name = "dataPrevista" id = "dataPrevista" value = "{{old('dataPrevista')}}">
            
                @error('dataPrevista')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>
            <button type = "submit" class = "btn btn-primary btn-sm"> Salvar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm"> Cancelar </button>
        </form>
    </div>
</div>
@endsection