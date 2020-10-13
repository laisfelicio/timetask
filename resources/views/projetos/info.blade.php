@extends('layouts.base', ["current" => "Projetos"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <h5 class = "card-title"> Informações sobre o projeto </h5>
        <label for = "nomeProjeto"> Nome do Projeto </label>
        <input type = "text" class = "form-control" name = "nomeProjeto" id = "nomeProjeto"  value = "{{$projeto->nome}}" readonly>
        <label for = "descricaoProjeto"> Descrição </label>
        <input type = "text" class = "form-control" name = "descricaoProjeto" id = "descricaoProjeto"  value = "{{$projeto->descricao}}" readonly> 
        <label for = "clienteProjeto"> Cliente </label>
        <input type = "text" class = "form-control" name = "clienteProjeto" id = "clienteProjeto"  value = "{{$projeto->cliente}}" readonly> 
                  
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
                                        <td>{{$usu->idUsuario}}</td>
                                        <td>{{$usu->nomeUsuario}}</td>
                                        <td>{{$usu->emailUsuario}}</td>
                                        <td>
                                            <a href = "/projetousuario/apagar/{{$usu->id}}" class = "btn btn-sm btn-danger"> Desalocar </a>
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
        

    </div>
    <div class = "card-footer">
        <a href = "/projetousuario/alocar/{{$projeto->id}}" class = "btn btn-sm btn-primary" role = "button"> Alocar novos usuários </a>
</div>
@endsection