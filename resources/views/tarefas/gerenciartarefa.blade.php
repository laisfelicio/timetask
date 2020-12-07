@extends('layouts.baseAt', ["current" => "tarefas", "titulo" => "Tarefas"])

@section('body')
<div class = "card">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Gerenciar tarefa</h4>
        </div>
    </div>
    <div class = "card-body">
        <hr style="border-top: 1px solid black;">
        <br>
        <form action = "/gerenciarTarefa" method="POST">
            @csrf
            <div class = "row">
                <div class="col-sm-12">
                    <div class = "card border-secondary">
                        <div class = "card-body">
                            <input type="hidden" id="idTarefa" name="idTarefa" value="{{$tarefa->id}}">
                            <div class = "form-group">
                                <input type = "text" class = "form-control input-lg" name = "nomeTarefa" id = "nomeTarefa"  value = "{{$tarefa->nome}}">
                            </div>
                            <div class = "form-group">
                                <input type = "text" class = "form-control border-light" name = "nomeProjeto" id = "nomeProjeto"  value = "{{$tarefa->projeto->nome}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
               
                
            </div>
            <hr style="border-top: 1px solid black;">
            <div class = "row">
                <div class="col-sm-6">
                    <h5><b>Status</b></h5>
                    <div class = "form-group">
                        <select class = "form-control" name = "statusTarefa" id = "statusTarefa" >
                            @foreach($statusTarefa as $status)
                                @if($status->id == $tarefa->status_id)
                                    <option value = {{$status->id}} selected>{{$status->nome}}</option>
                                @else
                                    <option value = {{$status->id}}>{{$status->nome}}</option>
                                @endif
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    @if($tarefa->status_id != 4)
                    <h5><b>
                        @if($infoUsu->ultimo_start <= $infoUsu->ultimo_stop)
                            Iniciar Trabalho
                        @else
                            Pausar Trabalho
                        @endif
                    </h5></b>    

                    <div class = "form-group">
                        @if($infoUsu->ultimo_start <= $infoUsu->ultimo_stop)
                            <a href = "/comecatimer/{{$tarefa->id}}" class="btn btn-success btn-round"> 
                                <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-play-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.596 8.697l-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
                                </svg>
                            </a>
                        @else
                            <a href = "/stoptimer/{{$tarefa->id}}" class="btn btn-danger btn-round"> 
                                <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-pause-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.5 3.5A1.5 1.5 0 0 1 7 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5zm5 0A1.5 1.5 0 0 1 12 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5z"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            <div class = "row">
               
            </div>
            <hr style="border-top: 1px solid black;">
            <div class="row">
                <div class="col-sm-6">
                    <h5><b>Histórico geral</b></h5>
                    <div class="card scroll">
                      <div class="card-body">
                        @if(count($tarefasUsuarios) > 1)
                            <table class = "table table-ordered table hover">
                                <thead>
                                    <th> Código </th>
                                    <th> Nome </th>
                                    <th> Tempo Trabalhado </th>
                                    <th> Iniciado pela ultima vez em  <th>
                                </thead>
                                <tbody>
                                    @foreach($tarefasUsuarios as $tarefaUsuario)
                                        
                                            <tr>
                                            <td> {{$tarefaUsuario->user_id}} </td>
                                            <td> {{$tarefaUsuario->nomeUsuario}} </td>
                                            <td> {{$tarefaUsuario->tempo_gasto}} </td>
                                            @if($tarefaUsuario->ultimo_start == "1920-01-01 01:00:00")
                                                <td> - </td>
                                            @else
                                                <td> {{$tarefaUsuario->ultimo_start}} </td>
                                            @endif
                                            </tr>
                                       
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                      <h5><b>Seu histórico</b></h5>
                    <div class="card">
                      <div class="card-body scroll">
                        <table class = "table table-ordered table hover">
                            <thead>
                                <th> Total horas</th>
                                <th> Tarefa iniciada pela ultima vez em: </th>
                                <th> Tarefa pausada pela ultima vez em: </th>
                            </thead>
                            <tbody>
                                
                                    <tr>
                                        
                                            <td> {{$infoUsu->tempo_gasto}} </td>
                                            @if($infoUsu->ultimo_start == "1920-01-01 01:00:00")
                                                <td> - </td>
                                            @else
                                                <td> {{$infoUsu->ultimo_start}} </td>
                                            @endif

                                            @if($infoUsu->ultimo_stop == "1920-01-01 01:00:00")
                                                <td> - </td>
                                            @else
                                                <td> {{$infoUsu->ultimo_stop}} </td>
                                            @endif
                                        
                                    </tr>
                                
                            </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
            </div>
            <button type = "submit" class = "btn btn-primary btn-lg btn-round"> Salvar Alterações</button>
        </form>
        
        <hr style="border-top: 1px solid black;">
        <br>
        <h5> Comentários </h5>
        <form action = "/comentarios" method="POST">
            @csrf
            <div class = "row">
                <div class="col-sm-12">
                    <div class = "card">
                        <div class = "card-body">
                            <input type="hidden" id="idTarefa" name="idTarefa" value="{{$tarefa->id}}">
                            <div class = "form-group">
                                <input type = "text" class = "form-control input-lg" name = "comentario" id = "comentario">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type = "submit" class = "btn btn-primary btn-round"> Adicionar comentário</button>
        </form>
        <hr style="border-top: 1px solid black;">

        @foreach($tarefa->comentarios as $comentario)
            <div class = "row">
                <div class="col-sm-12">
                    <div class = "card bg-comentario" style = "color: #000000">
                        <div class = "card-header" style = "color: #54327B"> <b>{{$comentario->nomeUsuario}} ( {{$comentario->emailUsuario}} ) :</b></div>
                        <div class = "card-body">
                            {{$comentario->comentario}}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>



    
   
</div>
@endsection