@extends('layouts.baseAt', ["current" => "clientes", "titulo" => "Clientes"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Novo cliente</h4>
        </div>
    </div>
    <div class = "card-body">     
        <form action = "/clientes" method="POST">
            @csrf
            <div class = "form-group">
                <label for = "nomeCliente"> Nome do cliente </label>
                <input type = "text" class = "form-control" name = "nomeCliente" id = "nomeCliente" placeHolder = "Cliente" value = "{{old('nomeCliente')}}">
                @error('nomeCliente')
                    <p class = "text-danger"> {{$message}} </p>
                @enderror
            
            </div>
            <button type = "submit" class = "btn btn-primary btn-sm btn-round"> Salvar </button>
            <button type = "cancel" class = "btn btn-danger btn-sm btn-round"> Cancelar </button>
        </form>
    </div>
</div>
@endsection