@extends('layouts.baseAt', ["current" => "timesheet", "titulo" => "Histórico de horas"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Editar histórico</h4>
        </div>
    </div>
    <div class = "card-body">
        <form action = "/timesheet/{{$historico->id}}" method="POST">
            @csrf
            <div class = "form-group">
                <label for = "nomeUsuario"> Nome da tarefa </label><br>
                <input type = "text" class = "form-control" name = "nomeTarefa" id = "nomeTarefa" value = "{{$historico->nomeTarefa}}" readonly>
            </div><br>
            <div class = "form-group">
                <label for = "dia"> Data </label><br>
                <input type = "text" class = "form-control" name = "dia" id = "dia" value = "{{$historico->dia->format('d/m/Y')}}" readonly>
            </div><br>  
            <div class = "form-group">
                <label for = "tempo"> Hora Início </label>
                <input type = "time" class = "form-control" name = "horaInicio" id = "horaInicio" step="1" value = {{$historico->horaInicio}}>
            </div><br>  
            <div class = "form-group">
                <label for = "tempo"> Hora Fim </label>
                <input type = "time" class = "form-control" name = "horaFim" id = "horaFim" step="1" value = {{$historico->horaFim}}>
            </div><br>
            <button type = "submit" class = "btn btn-primary btn-sm btn-round"> Salvar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm btn-round"> Cancelar </button>
        </form>
    </div>
</div>
@endsection