@extends('layouts.baseAt', ["current" => "clientes", "titulo" => "Clientes"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Clientes</h4>
        </div>
    </div>
    <div class = "card-body">
        @if(count($clientes) > 0)
        <table class = "table table-ordered table hover">
            <thead>
                <th> Código </th>
                <th> Nome </th>
                @if(Auth::user()->admin == 1)
                    <th> Ações </th>
                @endif
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                <tr>
                    <td>{{$cliente->id}}</td>
                    <td>{{$cliente->nome}}</td>
                    @if(Auth::user()->admin == 1)
                        <td>
                            <a href = "/clientes/editar/{{$cliente->id}}" class = "btn btn-sm btn-primary btn-round"> Editar </a>
                            <a href = "/clientes/apagar/{{$cliente->id}}" class = "btn btn-sm btn-danger btn-round"> Apagar </a>
                        </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
   
    <div class = "card-footer">
        @if(Auth::user()->admin == 1)
            <a href = "clientes/novo" class = "btn btn-sm btn-primary btn-round" role = "button"> Novo cliente </a>
            <form method = "POST" action="{{ route('clientes.download') }}" >
                @csrf
                <input type = "hidden" name = "clientes" value='<?= $clientes ?>'></input>
                <button type = "submit" class = "btn btn-info btn-sm btn-round"> Download Relatório</button>
            </form>
        @endif
    </div>
    
</div>
@endsection