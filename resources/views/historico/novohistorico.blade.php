@extends('layouts.baseAt', ["current" => "timesheet", "titulo" => "Histórico de horas"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Cadastrar horas</h4>
        </div>
    </div>
    <div class = "card-body">
        <h5> Registrar horas </h5>
        <form action = "/timesheet" method="POST">
            @csrf
            <div class="form-group">
                <label for="cliente">Tarefa</label>
                <select class="form-control" id="tarefa" name = "tarefa">
                  @foreach(Auth::user()->tarefas as $tarefa) 
                    <option value = {{$tarefa->id}}>{{$tarefa->nome}}</option>
                  @endforeach
                </select>

                @error('tarefa')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>
            <div class = "form-group">
                <label for = "dia"> Data </label><br>
                <input type = "date" class = "form-control" name = "dia" id = "dia">
                @error('dia')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div><br>  
            <div class = "form-group">
                <label for = "horaInicio"> Hora Início </label>
                <input type = "time" class = "form-control" name = "horaInicio" id = "horaInicio" step="1" >
                @error('horaInicio')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div><br>  
            <div class = "form-group">
                <label for = "horaFim"> Hora Fim </label>
                <input type = "time" class = "form-control" name = "horaFim" id = "horaFim" step="1">
                @error('horaFim')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div><br>
            <button type = "submit" class = "btn btn-primary btn-sm btn-round"> Salvar </button>
            <a class = "btn btn-danger btn-sm btn-round" href = "{{url()->previous()}}"> Cancelar </a>
        </form>
    </div>
</div>
@endsection