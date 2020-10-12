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
          <li @if($current=="projetos") class="nav-item active" @else class="nav-item" @endif>
              <a class="nav-link" href="/projetos">Projetos </a>
           </li>
            <li @if($current=="tarefas") class="nav-item active" @else class="nav-item" @endif>
              <a class="nav-link" href="/tarefas">Tarefas </a>
            </li>
            <li @if($current=="clientes") class="nav-item active" @else class="nav-item" @endif>
              <a class="nav-link" href="/clientes">Clientes </a>
            </li>
            <li @if($current=="usuarios") class="nav-item active" @else class="nav-item" @endif>
              <a class="nav-link" href="/usuarios">Usuarios </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something here</a>
              </div>
            </li>
          
        </ul>
      </div>
    </nav>