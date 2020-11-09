@extends('layouts.baseAt', ["current" => "projetos", "titulo" => "Projeto"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <div class="card-header card-header-text card-header-rose">
            <div class="card-text">
              <h4 class="card-title">Novo projeto</h4>
            </div>
        </div>
        <form action = "/projetos" method="POST">
            @csrf
            <div class = "form-group">
                <label for = "nomeProjeto"> Nome do Projeto </label>
                <input type = "text" class = "form-control" name = "nomeProjeto" id = "nomeProjeto" value = "{{old('nomeProjeto')}}">
                
                @error('nomeProjeto')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            
            </div>
            <div class = "form-group">
                <label for = "descProjeto"> Descrição do Projeto </label>
                <input type = "text" class = "form-control" name = "descProjeto" id = "descProjeto" value = "{{old('descProjeto')}}">
            
                @error('descProjeto')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>
            <div class="form-group">
                <label for="cliente">Cliente</label>
                <select class="form-control" id="cliente" name = "cliente">
                  @foreach($clientes as $cliente) 
                    <option value = {{$cliente->id}}>{{$cliente->nome}}</option>
                  @endforeach
                </select>

                @error('cliente')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>
            <div class = "form-group">
                <label for = "dataPrevista"> Data prevista de entrega </label>
                <input type = "date" class = "form-control" name = "dataPrevista" id = "dataPrevista">
            
                @error('dataPrevista')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
                
            </div>
            <button type = "submit" class = "btn btn-primary btn-sm btn-round"> Salvar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm btn-round"> Cancelar </button>
        </form>
    </div>
</div>
@endsection