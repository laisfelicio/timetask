<nav class="navbar navbar-expand-lg navbar-dark rounded" style="background-color:#6C2A6A">
    <span class="navbar-brand mb-0 h1">TimeTask</span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
          <li @if($current=="home") class="nav-item active" @else class="nav-item" @endif>
            <a class="nav-link" href="/homepage">Home </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarUsuarios" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Projetos
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="/projetos">Consultar projetos</a>
              <a class="dropdown-item" href="/projetousuario/meusprojetos">Meus projetos</a>
              @if(Auth::user()->admin == 1)
                <a class="dropdown-item" href="/projetos/novo">Novo projeto</a>
              @endif
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarUsuarios" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Tarefas
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="/tarefas">Consultar Tarefas</a>
              <a class="dropdown-item" href="/tarefausuario/minhastarefas">Minhas Tarefas</a>
              <a class="dropdown-item" href="/tarefas/novo">Nova tarefa</a>
            </div>
          </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarUsuarios" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Clientes
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="/clientes">Clientes</a>
                @if(Auth::user()->admin == 1)
                  <a class="dropdown-item" href="/clientes/novo">Novo cliente</a>
                @endif
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarUsuarios" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Usuários
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="/usuarios">Usuários</a>
                @if(Auth::user()->admin == 1)
                  <a class="dropdown-item" href="/usuarios/registrar">Novo usuário</a>
                @endif
              </div>
            </li>
            <li @if($current=="kanban") class="nav-item active" @else class="nav-item" @endif>
              <a class="nav-link" href="/kanban">Quadro Kanban </a>
            </li>
          
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
          </li>
        </ul>
      </div>
    </nav>