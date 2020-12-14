@extends('layouts.baseAt', ["current" => "tarefas", "titulo" => "Tarefas"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">+ Info</h4>
        </div>
    </div>
    <div class = "card-body">
        <h5 class = "card-title"> Informações sobre a tarefa </h5>
        <label for = "nomeProjeto"> Nome da tarefa </label>
        <input type = "text" class = "form-control" name = "nomeTarefa" id = "nomeTarefa"  value = "{{$tarefa->nome}}" readonly>
        <label for = "nomeProjeto"> Projeto </label>
        <input type = "text" class = "form-control" name = "nomeProjeto" id = "nomeProjeto"  value = "{{$tarefa->projeto->nome}}" readonly>
        <label for = "descricaoTarefa"> Descrição </label>
        <input type = "text" class = "form-control" name = "descricaoTarefa" id = "descricaoTarefa"  value = "{{$tarefa->descricao}}" readonly> 
        

                  
        <hr style="border-top: 1px solid black;">
        <div class = "row">
            <div class="col-sm-4">
                <div class = "card border-light">
                    <div class = "card-body">
                        <label for = "dataPrevista"> Data Prevista </label>
                        <input type = "text" class = "form-control" name = "dataPrevista" id = "dataPrevista"  value = "{{$tarefa->data_prevista->format('d/m/Y')}}" readonly> 
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class = "card border-light">
                    <div class = "card-body">
                        <label for = "tempoGasto"> Tempo Gasto </label>
                        <input type = "text" class = "form-control" name = "tempoGasto" id = "tempoGasto"  value = "{{$tarefa->tempo_gasto}}" readonly> 
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class = "card border-light">
                    <div class = "card-body">
                        <label for = "tempoPrevisto"> Tempo Previsto </label>
                        <input type = "text" class = "form-control" name = "tempoPrevisto" id = "tempoPrevisto"  value = "{{$tarefa->tempo_previsto}}" readonly> 
                    </div>
                </div>
            </div>
        </div>
        <hr style="border-top: 1px solid black;">
        <div class = "row">
            <div class="col-sm-12">
                <h5> Usuários alocados nessa tarefa </h5>
                <div class = "card">
                    <div class = "card-body">
                        @if(count($tarefa->users) > 0)
                            <table class = "table table-ordered table hover">
                                <thead>
                                    <th> Código Usuário</th>
                                    <th> Nome </th>
                                    <th> Email </th>
                                    @if(Auth::user()->admin == 1)
                                        <th> Ações </th>
                                    @endif
                                </thead>
                                <tbody>
                                    @foreach($tarefa->users as $usu)
                                    <tr>
                                        <td>{{$usu->id}}</td>
                                        <td>{{$usu->name}}</td>
                                        <td>{{$usu->email}}</td>
                                        @if(Auth::user()->admin == 1)
                                            <td>
                                                <a href = "/tarefausuario/apagar/{{$usu->id}}/{{$tarefa->id}}" class = "btn btn-sm btn-danger btn-round"> Desalocar </a>
                                            </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <hr style="border-top: 1px solid black;">
        

    </div>
    <div class = "card-footer">
        <a href = "/tarefausuario/{{$tarefa->projeto->id}}/{{$tarefa->id}}" class = "btn btn-sm btn-primary" role = "button"> Alocar novos usuários </a>
    </div>
@endsection