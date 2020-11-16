@extends('layouts.baseAt', ["current" => "relatorios", "titulo" => "Relatório"])

@section('body')

<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Relatório</h4>
        </div>
    </div>
    <div class = "card-body">

        
            <div class = "card">
                <div class = "card-body">
                    <form method = "GET" action = "/relatoriospdf/projetohoras/download">
                        <div class="form-group">
                            <label for="projeto">Projeto</label>
                            <select class="form-control" id="projeto" name = "projeto">
                                <option value = "">TODOS</option>
                                @foreach($projetos as $projeto) 
                                    <option value = {{$projeto->id}}>{{$projeto->nome}}</option>
                                @endforeach
                            </select>
                        </div>
        
                        <div class="form-group">
                            <label for="dataInicio">Data Inicial </label>
                            <input type = "date" id = "dataInicio" name = "dataInicio" class = "form-control">
                        </div>

                        <div class="form-group">
                            <label for="dataFim">Data Final </label>
                            <input type = "date" id = "dataFim" name = "dataFim" class = "form-control">
                        </div>
        
                        <button type = "submit" class = "btn btn-primary btn-sm btn-round"> Filtrar </button>
                    </form>
                </div>
            </div>
        
        
</div>
@endsection