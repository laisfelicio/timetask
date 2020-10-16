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
                <div class = "card border-light bg-info mb-3 rounded scroll">
                    <br>
                    @foreach($abertas as $tarefa)
                        <div class = "card border-info mb-3">
                            <div class = "card-header">{{$tarefa->nome}}</div>
                            <div class = "card-body">
                                    {{$tarefa->descricao}}
                                    <hr>
                                    <b> Data de entrega: </b> 15/02/2020
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-3">
                <h5>Em execução </h5>
                <div class = "card border-light bg-secondary mb-3 rounded scroll">
                    <br>
                    @foreach($exec as $tarefa)
                        <div class = "card border-secondary mb-3">
                            <div class = "card-header">{{$tarefa->nome}}</div>
                            <div class = "card-body">
                                    {{$tarefa->descricao}}
                                    <hr>
                                    <b> Data de entrega: </b> 15/02/2020
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-3">
                <h5>Homologação</h5>
                <div class = "card border-light bg-warning mb-3 rounded scroll">
                    <br>
                    @foreach($homolog as $tarefa)
                        <div class = "card border-warning mb-3">
                            <div class = "card-header">{{$tarefa->nome}}</div>
                            <div class = "card-body">
                                    {{$tarefa->descricao}}
                                    <hr>
                                    <b> Data de entrega: </b> 15/02/2020
                            </div>
                        </div>
                    @endforeach
                 </div>
            </div>
            <div class="col-sm-3">
                <h5>Finalizados</h5>
                <div class = "card border-light bg-success mb-3 rounded scroll">
                    <br>
                    @foreach($finalizadas as $tarefa)
                        <div class = "card border-success mb-3">
                            <div class = "card-header">{{$tarefa->nome}}</div>
                            <div class = "card-body">
                                    {{$tarefa->descricao}}
                                    <hr>
                                    <b> Data de entrega: </b> 15/02/2020
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection