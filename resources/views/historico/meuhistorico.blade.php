@extends('layouts.baseAt', ["current" => "timesheet", "titulo" => "Histórico de horas"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Meu histórico</h4>
        </div>
    </div>
    <div class = "card-body">
        <h5 class = "card-title"> Histórico de atividades </h5>
        @if(count($historicos) > 0)
        <p>
            <button class="btn btn-primary btn-round" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              OPÇÕES DE FILTRO
            </button>
        </p>
        <div class="collapse" id="collapseExample">
            <div class = "card">
                <div class = "card-body">
                    <form method = "GET" action = "/timesheet">
        
                        <div class="form-group">
                            <label for="tarefa">Tarefa</label>
                            <select class="form-control" id="tarefa" name = "tarefa">
                            <option value = "">TODOS</option>
                            @foreach($tarefas as $tarefa) 
                                <option value = {{$tarefa->id}}>{{$tarefa->nome}}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="dataInicio">Data Inicial </label>
                            <input type = "date" id = "dataInicio" name = "dataInicio" class = "form-control">
                        </div>

                        <div class="form-group">
                            <label for="dataFim">Data Final </label>
                            <input type = "date" id = "dataFim" name = "dataFim" class = "form-control">
                        </div>
        
                        <button type = "submit" class = "btn btn-primary btn-sm btn-round"> Filtrar </button>
                    </form>
                </div>
            </div>
        </div>
        <table class = "table table-ordered table hover">
            <thead>
                <th> Código Tarefa</th>
                <th> Nome</th>
                <th> Dia </th>
                <th> Horas </th>
                <th></th>
            </thead>
            <tbody>
                @foreach($historicos as $historico)
                <tr>
                    <td>{{$historico->tarefa_id}}</td>
                    <td>{{$historico->nomeTarefa}}</td>
                    <td>{{$historico->dia->format('d/m/Y')}}</td>
                    <td>{{$historico->horas}}</td>
                    <td>
                        <a href = "/editarTimeSheet/{{$historico->id}}" class = "btn btn-sm btn-primary btn-round"> 
                            <i class="material-icons">edit</i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
   
    <div class = "card-footer">
        <a href = "/timesheet/novo" class = "btn btn-sm btn-primary btn-round" role = "button"> Cadastrar horas </a>
        <form method = "POST" action="{{ route('timesheet.download') }}" >
            @csrf
            <input type = "hidden" name = "historicos" value='<?= $historicos ?>'></input>
            <button type = "submit" class = "btn btn-info btn-sm btn-round"> Download Relatório</button>
        </form>
    </div>
    
</div>
@endsection