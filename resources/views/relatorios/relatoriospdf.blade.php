@extends('layouts.baseAt', ["current" => "relatorios", "titulo" => "Relatórios"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Relatórios</h4>
        </div>
    </div>
    <div class = "card-body">
        <div class="card-deck">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title"><b>Projetos X Horas</b></h4>
              <p class="card-text">Quantas horas você trabalhou em um determinado período separado por projeto</p>
            </div>
            <div class="card-footer">
              <a href = "/relatoriospdf/userprojetohoras/" class = "btn btn-sm btn-primary" role = "button"> Consultar </a>
            </div>
          </div>
            @if(Auth::user()->admin == 1)
            <div class="card">
              <div class="card-body">
                <h4 class="card-title"><b>Usuários X Horas</b></h4>
                <p class="card-text">Quantas horas cada usuário trabalhou em determinado período de tempo.</p>
              </div>
              <div class="card-footer">
                <a href = "/relatoriospdf/usuariosHoras" class = "btn btn-sm btn-primary" role = "button"> Consultar </a>
              </div>
            </div>
            <div class="card">
                <div class="card-body">
                  <h4 class="card-title"><b>Projetos X Horas</b></h4>
                  <p class="card-text">Quantas horas cada projeto possui em determinado período de tempo.</p>
                </div>
                <div class="card-footer">
                  <a href = "/relatoriospdf/projetohoras" class = "btn btn-sm btn-primary" role = "button"> Consultar </a>
                </div>
            </div>

            <div class="card">
              <div class="card-body">
                <h4 class="card-title"><b>Usuários/Projetos X Horas</b></h4>
                <p class="card-text">Quantas horas cada usuário trabalhou em um determinado período separado por projeto</p>
              </div>
              <div class="card-footer">
                <a href = "/relatoriospdf/usuariosprojetohoras" class = "btn btn-sm btn-primary" role = "button"> Consultar </a>
            </div>
            @endif
          </div>

        </div>

        

        
    </div>
</div>
@endsection

