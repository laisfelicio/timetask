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