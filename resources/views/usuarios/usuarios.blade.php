@extends('layouts.baseAt', ["current" => "usuarios", "titulo" => "Usuários"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Usuários</h4>
        </div>
    </div>
    <div class = "card-body">
        @if(count($usuarios) > 0)
        <table class = "table table-ordered table hover">
            <thead>
                <th> Código </th>
                <th> Nome </th>
                <th> Email </th>
                <th> Ações </th>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                <tr>
                    <td>{{$usuario->id}}</td>
                    <td>{{$usuario->name}}</td>
                    <td>{{$usuario->email}}</td>
                    <td>
                        <a href = "/usuarios/editar/{{$usuario->id}}" class = "btn btn-sm btn-primary btn-round"> Editar </a>
                        <a href = "/usuarios/apagar/{{$usuario->id}}" class = "btn btn-sm btn-danger btn-round"> Apagar </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div class = "card-footer">
        <a href = "/usuarios/registrar" class = "btn btn-sm btn-primary" role = "button"> Novo Usuário </a>
        <form method = "POST" action="{{ route('usuarios.download') }}" >
            @csrf
            <input type = "hidden" name = "usuarios" value='<?= $usuarios ?>'></input>
            <button type = "submit" class = "btn btn-info btn-sm"> Download Relatório</button>
        </form>
    </div>
</div>
@endsection