@extends('layouts.baseAt', ["current" => "projetos", "titulo" => "Projetos"])

@section('body')


<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Editar projeto</h4>
        </div>
    </div>
    <div class = "card-body">
        <form action = "/projetos/{{$projeto->id}}" method="POST">
            @csrf
            <div class = "form-group">
                <label for = "nomeProjeto"> Nome do Projeto </label>
                <input type = "text" class = "form-control" name = "nomeProjeto" id = "nomeProjeto"  value = "{{$projeto->nome}}">
            
                @error('nomeProjeto')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>
            <div class = "form-group">
                <label for = "descProjeto"> Descrição do Projeto </label>
                <input type = "text" class = "form-control" name = "descProjeto" id = "descProjeto" value = "{{$projeto->descricao}}">
           
                @error('descProjeto')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>
            <div class="form-group">
                <label for="cliente">Cliente</label>
                <select class="form-control" id="cliente" name = "cliente">
                  @foreach($clientes as $cliente) 
                    @if($cliente->id == $projeto->cliente_id)
                        <option value = {{$cliente->id}} selected>{{$cliente->nome}}</option>
                    @else
                        <option value = {{$cliente->id}}>{{$cliente->nome}}</option>
                    @endif
                  @endforeach
                </select>
                @error('cliente')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name = "status">
                  @foreach($statusProjetos as $status) 
                    @if($status->id == $projeto->status_id)
                        <option value = {{$status->id}} selected>{{$status->nome}}</option>
                    @else
                        <option value = {{$status->id}}>{{$status->nome}}</option>
                    @endif
                  @endforeach
                </select>

                @error('status')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            </div>
            <div class = "form-group">
                <label for = "dataPrevista"> Data prevista de entrega </label>
                <input type = "date" class = "form-control" name = "dataPrevista" id = "dataPrevista" value = "{{$projeto->data_prevista}}">
            
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