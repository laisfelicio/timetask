@extends('layouts.base', ["current" => "Gerenciar tarefa"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <h5 class = "card-title"> Tarefas </h5>
        <form action = "/tarefas" method="POST">
            @csrf
            <div class = "form-group">
                <input type = "text" class = "form-control" name = "nomeTarefa" id = "nomeTarefa"  value = "{{$tarefa->nome}}">
            </div>
            <div class = "form-group">
                <label for = "nomeProjeto"> </label>
                <input type = "text" class = "form-control" name = "nomeProjeto" id = "nomeProjeto"  value = "{{$projeto->nome}}" readonly>
            </div>
            <div class = "rom">
                <a href = "/comecatimer/{{$tarefa->id}}" class="btn btn-success"> 
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-play-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.596 8.697l-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
                      </svg>
                </a>
                <a href = "/stoptimer/{{$tarefa->id}}" class="btn btn-danger"> 
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pause-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.5 3.5A1.5 1.5 0 0 1 7 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5zm5 0A1.5 1.5 0 0 1 12 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5z"/>
                      </svg>
                </a>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Outros usuários</h5>
                        @if(count($tarefasUsuarios) > 1)
                            <table class = "table table-ordered table hover">
                                <thead>
                                    <th> Código </th>
                                    <th> Nome </th>
                                    <th> Tempo Trabalhado </th>
                                    <th> Ultimo start <th>
                                </thead>
                                <tbody>
                                    @foreach($tarefasUsuarios as $tarefaUsuario)
                                        @if($tarefaUsuario->user_id != Auth::user()->id)
                                            <tr>
                                            <td> {{$tarefaUsuario->user_id}} </td>
                                            <td> {{$tarefaUsuario->nomeUsuario}} </td>
                                            <td> {{$tarefaUsuario->tempo_gasto}} </td>
                                            <td> {{$tarefaUsuario->ultimo_start}} </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Seu histórico</h5>
                        <table class = "table table-ordered table hover">
                            <thead>
                                <th> Total horas</th>
                                <th> Tarefa iniciada pela ultima vez em: </th>
                                <th> Tarefa pausada pela ultima vez em: </th>
                            </thead>
                            <tbody>
                                @if(count($infoUsu) > 0)
                                    <tr>
                                        @foreach($infoUsu as $usu)
                                            <td> {{$usu->tempo_gasto}} </td>
                                            <td> {{$usu->ultimo_start}} </td>
                                            <td> {{$usu->ultimo_start}} </td>
                                        @endforeach
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
            </div>
        </form>
    </div>
   
</div>
@endsection