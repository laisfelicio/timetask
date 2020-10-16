@extends('layouts.baseAt', ["current" => "projetos"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <form action = "/projetos" method="POST">
            @csrf
            <div class = "form-group">
                <label for = "nomeProjeto"> Nome do Projeto </label>
                <input type = "text" class = "form-control" name = "nomeProjeto" id = "nomeProjeto" placeHolder = "Nome do projeto">
            </div>
            <div class = "form-group">
                <label for = "descProjeto"> Descrição do Projeto </label>
                <input type = "text" class = "form-control" name = "descProjeto" id = "descProjeto" placeHolder = "Breve descrição do projeto">
            </div>
            <div class="form-group">
                <label for="cliente">Cliente</label>
                <select class="form-control" id="cliente" name = "cliente">
                  @foreach($clientes as $cliente) 
                    <option value = {{$cliente->id}}>{{$cliente->nome}}</option>
                  @endforeach
                </select>
            </div>
            <div class = "form-group">
                <label for = "dataPrevista"> Data prevista de entrega </label>
                <input type = "date" class = "form-control" name = "dataPrevista" id = "dataPrevista">
            </div>
            <button type = "submit" class = "btn btn-primary btn-sm"> Salvar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm"> Cancelar </button>
        </form>
    </div>
</div>
@endsection