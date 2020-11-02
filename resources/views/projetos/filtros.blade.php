<p>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
      OPÇÕES DE FILTRO
    </button>
</p>
<div class="collapse" id="collapseExample">
    <div class = "card">
        <div class = "card-body">
            <form method = "GET" action = {{$action}}>
                <div class="form-group">
                    <label for="statusProjeto">Status</label>
                    <select class="form-control" id="statusProjeto" name = "statusProjeto">
                    @foreach($statusProjetos as $status) 
                        <option value = {{$status->id}}>{{$status->nome}}</option>
                    @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="clienteProjeto">Cliente</label>
                    <select class="form-control" id="clienteProjeto" name = "clienteProjeto">
                    <option value = "">TODOS</option>
                    @foreach($clientes as $cliente) 
                        <option value = {{$cliente->id}}>{{$cliente->nome}}</option>
                    @endforeach
                    </select>
                </div>

                <button type = "submit" class = "btn btn-primary btn-sm"> Filtrar </button>
            </form>
        </div>
    </div>
</div>