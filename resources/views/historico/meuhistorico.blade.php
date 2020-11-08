@extends('layouts.baseAt', ["current" => "timesheet"])

@section('body')
<div class = "card border">
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
                        <a href = "/editarTimeSheet/{{$historico->id}}" class = "btn btn-sm btn-primary"> 
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
    </div>
    
</div>
@endsection