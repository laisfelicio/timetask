@extends('layouts.baseAt', ["current" => "kanban"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <h5 class = "card-title"> Quadro Kanban </h5>
        <hr style="border-top: 1px solid black;">
        <br>
        <div class = "row">
            <div class="col-sm-3">
                <h5>Abertas</h5>
                <div class = "card border-light bg-info mb-3 rounded scroll mr-2">
                    <br>
                    @foreach($abertas as $tarefa)
                        <div class = "card border-info mb-1">
                            <a href = "/tarefausuario/info/{{$tarefa->projeto_id}}/{{$tarefa->id}}" class = "btn btn-primary btn-fab btn-fab-mini btn-round"> <i class="material-icons">add</i> </a>

                            <div class = "card-header">{{$tarefa->nome}}
                                @if($dataAtual > $tarefa->data_prevista)
                                    <i class="material-icons" style = "color: #ff0000;">warning</i>
                                @endif
                            </div>
                            <div class = "card-body">
                                    {{$tarefa->descricao}}
                                    <hr>
                                    <b> Data prevista: </b> {{$tarefa->data_prevista}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-3">
                <h5>Em execução </h5>
                <div class = "card border-light bg-secondary mb-3 rounded scroll mr-2">
                    <br>
                    @foreach($exec as $tarefa)
                    <div class = "card border-secondary mb-1">
                        <a href = "/tarefausuario/info/{{$tarefa->projeto_id}}/{{$tarefa->id}}" class = "btn btn-primary btn-fab btn-fab-mini btn-round"> <i class="material-icons">add</i> </a>

                        <div class = "card-header">{{$tarefa->nome}}
                            @if($dataAtual > $tarefa->data_prevista)
                                <i class="material-icons" style = "color: #ff0000;">warning</i>
                            @endif
                        </div>
                        <div class = "card-body">
                                {{$tarefa->descricao}}
                                <hr>
                                <b> Data prevista: </b> {{$tarefa->data_prevista}}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-3">
                <h5>Homologação</h5>
                <div class = "card border-light bg-warning mb-3 rounded scroll mr-2">
                    <br>
                    @foreach($homolog as $tarefa)
                    <div class = "card border-warning mb-1">
                        <a href = "/tarefausuario/info/{{$tarefa->projeto_id}}/{{$tarefa->id}}" class = "btn btn-primary btn-fab btn-fab-mini btn-round"> <i class="material-icons">add</i> </a>

                        <div class = "card-header">{{$tarefa->nome}}
                            @if($dataAtual > $tarefa->data_prevista)
                                <i class="material-icons" style = "color: #ff0000;">warning</i>
                            @endif
                        </div>
                        <div class = "card-body">
                                {{$tarefa->descricao}}
                                <hr>
                                <b> Data prevista: </b> {{$tarefa->data_prevista}}
                        </div>
                    </div>
                    @endforeach
                 </div>
            </div>
            <div class="col-sm-3">
                <h5>Finalizados</h5>
                <div class = "card border-light bg-success mb-3 rounded scroll mr-2">
                    <br>
                    @foreach($finalizadas as $tarefa)
                    <div class = "card border-success mb-1">
                        <a href = "/tarefausuario/info/{{$tarefa->projeto_id}}/{{$tarefa->id}}" class = "btn btn-primary btn-fab btn-fab-mini btn-round"> <i class="material-icons">add</i> </a>

                        <div class = "card-header">{{$tarefa->nome}}
                            @if($dataAtual > $tarefa->data_prevista)
                                <i class="material-icons" style = "color: #ff0000;">warning</i>
                            @endif
                        </div>
                        <div class = "card-body">
                                {{$tarefa->descricao}}
                                <hr>
                                <b> Data de entrega: </b> {{$tarefa->data_finalizacao}}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection