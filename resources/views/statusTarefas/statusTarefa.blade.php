@extends('layouts.base', ["current" => "Tarefas"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <h5 class = "card-title"> Status Tarefas </h5>
        @if(count($statusTarefas) > 0)
        <table class = "table table-ordered table hover">
            <thead>
                <th> Código </th>
                <th> Nome </th>
                <th> Ações </th>
            </thead>
            <tbody>
                @foreach($statusTarefas as $status)
                <tr>
                    <td>{{$status->id}}</td>
                    <td>{{$status->nome}}</td>
                    <td>
                        @if($status->id > 1)
                            <a href = "/statustarefa/editar/{{$status->id}}" class = "btn btn-sm btn-primary"> Editar </a>
                            <a href = "/statustarefa/apagar/{{$status->id}}" class = "btn btn-sm btn-danger"> Apagar </a>
                        @endif 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div class = "card-footer">
        <a href = "/statustarefa/novo" class = "btn btn-sm btn-primary" role = "button"> Novo Status </a>
</div>
@endsection