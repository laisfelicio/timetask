@extends('layouts.baseAt', ["current" => "categorias"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <h5 class = "card-title"> Status Projeto </h5>
        @if(count($statusProjetos) > 0)
        <table class = "table table-ordered table hover">
            <thead>
                <th> Código </th>
                <th> Nome </th>
                <th> Ações </th>
            </thead>
            <tbody>
                @foreach($statusProjetos as $status)
                <tr>
                    <td>{{$status->id}}</td>
                    <td>{{$status->nome}}</td>
                    <td>
                        @if($status->id > 1)
                            <a href = "/statusprojeto/editar/{{$status->id}}" class = "btn btn-sm btn-primary"> Editar </a>
                            <a href = "/statusprojeto/apagar/{{$status->id}}" class = "btn btn-sm btn-danger"> Apagar </a>
                        @endif 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div class = "card-footer">
        <a href = "/statusprojeto/novo" class = "btn btn-sm btn-primary" role = "button"> Novo Status </a>
</div>
@endsection