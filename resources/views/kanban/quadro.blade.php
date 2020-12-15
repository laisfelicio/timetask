@extends('layouts.baseAt', ["current" => "kanban", "titulo" => "Kanban"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Kanban</h4>
        </div>
    </div>
    <div class = "card-body">
        <br>
        <div class = "row">
            <div class="col-sm-3">
                <h5>Abertas</h5>
                <div class = "card border-light bg-info mb-3 rounded scroll mr-2">
                    <br>
                    @foreach($abertas as $tarefa)
                        <div class = "card border-info mb-1">
                            @if(Auth::user()->admin == 1)
                                <a href = "/tarefausuario/info/{{$tarefa->projeto_id}}/{{$tarefa->id}}" class = "btn-fab btn-fab-mini btn-round"> <i class="material-icons">info</i> </a>
                            @endif
                            <div class = "card-header"><b>{{$tarefa->nome}} <br> Projeto: {{$tarefa->projeto->nome}} </b>
                                @if($dataAtual > $tarefa->data_prevista)
                                    <i class="material-icons" style = "color: #ff0000;">warning</i>
                                @endif
                            </div>
                            <hr>
                            <div class = "card-body">
                                    {{$tarefa->descricao}}
                                    <hr>
                                    <b> Data prevista: </b> {{$tarefa->data_prevista->format('d/m/Y')}}
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
                        @if(Auth::user()->admin == 1)
                            <a href = "/tarefausuario/info/{{$tarefa->projeto_id}}/{{$tarefa->id}}" class = "btn-fab btn-fab-mini btn-round"> <i class="material-icons">info</i> </a>
                        @endif
                        <div class = "card-header"><b>{{$tarefa->nome}} <br> Projeto: {{$tarefa->projeto->nome}} </b>
                            @if($dataAtual > $tarefa->data_prevista)
                                <i class="material-icons" style = "color: #ff0000;">warning</i>
                            @endif
                            
                        </div>
                        <hr>
                        <div class = "card-body">
                                {{$tarefa->descricao}}
                                <hr>
                                <b> Data prevista: </b> {{$tarefa->data_prevista->format('d/m/Y')}}
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
                        @if(Auth::user()->admin == 1)
                            <a href = "/tarefausuario/info/{{$tarefa->projeto_id}}/{{$tarefa->id}}" class = "btn-fab btn-fab-mini btn-round"> <i class="material-icons">info</i> </a>
                        @endif
                        <div class = "card-header"><b>{{$tarefa->nome}} <br> Projeto: {{$tarefa->projeto->nome}} </b>
                            @if($dataAtual > $tarefa->data_prevista)
                                <i class="material-icons" style = "color: #ff0000;">warning</i>
                            @endif
                        </div>
                        <hr>
                        <div class = "card-body">
                                {{$tarefa->descricao}}
                                <hr>
                                <b> Data prevista: </b> {{$tarefa->data_prevista->format('d/m/Y')}}
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
                        @if(Auth::user()->admin == 1)
                            <a href = "/tarefausuario/info/{{$tarefa->projeto_id}}/{{$tarefa->id}}" class = "btn-fab btn-fab-mini btn-round"> <i class="material-icons outlined">info</i> </a>
                        @endif
                        <div class = "card-header"><b>{{$tarefa->nome}} <br> Projeto: {{$tarefa->projeto->nome}} </b>
                            @if($dataAtual > $tarefa->data_prevista)
                                <i class="material-icons" style = "color: #ff0000;">warning</i>
                            @endif
                        </div>
                        <hr>
                        <div class = "card-body">
                                {{$tarefa->descricao}}
                                <hr>
                                <b> Data de entrega: </b> {{$tarefa->data_finalizacao->format('d/m/Y')}}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection