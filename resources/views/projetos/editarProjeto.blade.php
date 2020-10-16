@extends('layouts.baseAt', ["current" => "projetos"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <form action = "/projetos/{{$projeto->id}}" method="POST">
            @csrf
            <div class = "form-group">
                <label for = "nomeProjeto"> Nome do Projeto </label>
                <input type = "text" class = "form-control" name = "nomeProjeto" id = "nomeProjeto"  value = "{{$projeto->nome}}">
            </div>
            <div class = "form-group">
                <label for = "descProjeto"> Descrição do Projeto </label>
                <input type = "text" class = "form-control" name = "descProjeto" id = "descProjeto" value = "{{$projeto->descricao}}">
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
            </div>
        
            <button type = "submit" class = "btn btn-primary btn-sm"> Salvar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm"> Cancelar </button>
        </form>
    </div>
</div>
@endsection