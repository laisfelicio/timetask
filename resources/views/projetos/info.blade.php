@extends('layouts.baseAt', ["current" => "projetos", "titulo" => "Projeto - Informações"])

@section('body')

<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">+ Info</h4>
        </div>
    </div>
    <div class = "card-body">
        <h5 class = "card-title"> Informações sobre o projeto </h5>
        <label for = "nomeProjeto"> Nome do Projeto </label>
        <input type = "text" class = "form-control" name = "nomeProjeto" id = "nomeProjeto"  value = "{{$projeto->nome}}" readonly>
        <label for = "descricaoProjeto"> Descrição </label>
        <input type = "text" class = "form-control" name = "descricaoProjeto" id = "descricaoProjeto"  value = "{{$projeto->descricao}}" readonly> 
        <label for = "clienteProjeto"> Cliente </label>
        <input type = "text" class = "form-control" name = "clienteProjeto" id = "clienteProjeto"  value = "{{$projeto->cliente->nome}}" readonly> 
                  
        <hr style="border-top: 1px solid black;">
        <div class = "row">
            <div class="col-sm-6">
                <div class = "card border-light">
                    <div class = "card-body">
                        <label for = "dataPrevista"> Data Prevista </label>
                        <input type = "text" class = "form-control" name = "dataPrevista" id = "dataPrevista"  value = "{{$projeto->data_prevista}}" readonly> 
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class = "card border-light">
                    <div class = "card-body">
                        <label for = "tempoGasto"> Tempo Gasto </label>
                        <input type = "text" class = "form-control" name = "tempoGasto" id = "tempoGasto"  value = "{{$projeto->tempo_gasto}}" readonly> 
                    </div>
                </div>
            </div>
        </div>

        <div class = "row">
            <div class="col-sm-12">
                <h5><b>Usuários alocados </b> </h5>
                <div class = "card">
                    <div class = "card-body">
                        @if(count($alocados) > 0)
                            <table class = "table table-ordered table hover">
                                <thead>
                                    <th> Código Usuário</th>
                                    <th> Nome </th>
                                    <th> Email </th>
                                    <th> Ações </th>
                                </thead>
                                <tbody>
                                    @foreach($alocados as $usu)
                                    <tr>
                                        <td>{{$usu->id}}</td>
                                        <td>{{$usu->name}}</td>
                                        <td>{{$usu->email}}</td>
                                        <td>
                                            <a href = "/projetousuario/apagar/{{$projeto->id}}/{{$usu->id}}" class = "btn btn-sm btn-danger btn-round"> Desalocar </a>
                                        </td>
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
        <div class = "row">
            <div class="col-sm-12">
                <h5><b>Tarefas </b> </h5>
                <div class = "card">
                    <div class = "card-body">
                        @if(count($tarefas) > 0)
                            <table class = "table table-ordered table hover">
                                <thead>
                                    <th> Código </th>
                                    <th> Nome </th>
                                    <th> Status </th>
                                    <th> Ações </th>
                                    <th> </th>
                                </thead>
                                <tbody>
                                    @foreach($tarefas as $tarefa)
                                    <tr>
                                        <td>{{$tarefa->id}}</td>
                                        <td>{{$tarefa->nome}}</td>
                                        <td>{{$tarefa->status->nome}}</td>
                                        <td>
                                            <a href = "/tarefas/editar/{{$tarefa->id}}" class = "btn btn-sm btn-primary btn-round"> Editar </a>
                                            <a href = "/tarefausuario/{{$projeto->id}}/{{$tarefa->id}}" class = "btn btn-sm btn-primary btn-round"> Alocar usuário </a>
                                            <a href = "/tarefausuario/info/{{$tarefa->projeto->id}}/{{$tarefa->id}}" class = "btn btn-sm btn-primary btn-round"> + Info </a>
                                            <a href = "/tarefas/apagar/{{$tarefa->id}}" class = "btn btn-sm btn-danger btn-round"> Apagar </a>
                                        </td>
                                        <td> 
                                            @if($dataAtual > $tarefa->data_prevista)
                                                <i class="material-icons" style = "color: #ff0000;">warning</i>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        

    </div>
    <div class = "card-footer">
        <a href = "/projetousuario/alocar/{{$projeto->id}}" class = "btn btn-sm btn-primary btn-round" role = "button"> Alocar novos usuários </a>
</div>
@endsection