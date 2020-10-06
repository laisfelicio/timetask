<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projeto;
use App\ProjetoUsuario;
use App\User;
use App\Tarefa;
use App\TarefaUsuario;
use Illuminate\Support\Collection;

use Illuminate\Support\Facades\Auth;

class ControllerTarefaUsuario extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($idProjeto, $idTarefa)
    {
        //
        echo "oiiiiiiiiiiiiiie";
        $projeto = Projeto::find($idProjeto);
        $tarefa = Tarefa::find($idTarefa);
        $usuarios= ProjetoUsuario::where('projeto_id', $idProjeto)->get();
        return view('tarefas.alocarusuario', compact('projeto', 'usuarios', 'tarefa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        echo "STOREEEE";
        $tarefaUsu = new TarefaUsuario();
        $tarefaUsu->tarefa_id = $request->input('idTarefa');
        $tarefaUsu->user_id = $request->input('usuario');
        $tarefaUsu->tempo_gasto = "00:00:00";
        $tarefaUsu->ultimo_start = "1920-01-01 01:00:00";
        $tarefaUsu->save();
        return redirect('/tarefausuario/info/'.$request->input('idProjeto')."/".$request->input('idTarefa'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idProjeto, $idTarefa)
    {
        //
        $alocados= TarefaUsuario::where('tarefa_id', $idTarefa)->get();
        $projeto = Projeto::find($idProjeto);
        $tarefa = Tarefa::find($idTarefa);
        return view('tarefas.info', compact('alocados', 'projeto', 'tarefa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rota, $id)
    {
        //
        echo "destroy";
        var_dump($rota);
        var_dump($id);
        $tarefaUsuario = TarefaUsuario::find($id);
        var_dump($tarefaUsuario);
        $tarefaId = $tarefaUsuario->tarefa_id;
        $projetoId = Tarefa::find($tarefaId)->projeto_id;

        if(isset($tarefaUsuario)){
            $tarefaUsuario->delete();
        }
        return redirect("/tarefausuario/info/".$projetoId."/".$tarefaId);
    }

    public function getTarefasUsuario(){
        echo "usuario = ".Auth::user()->id;
        $usuarioId = Auth::user()->id;
        $tarefas = TarefaUsuario::where('user_id', $usuarioId)->get();
        return view('tarefas.minhastarefas', compact('tarefas'));

        return "";
    }
    
    public function detalhesTarefa($tarefaId){
        $tarefa = Tarefa::find($tarefaId);
        $projeto = Projeto::find($tarefa->projeto_id);
        $tarefasUsuarios = TarefaUsuario::where('tarefa_id', $tarefaId)->get();
        $infoUsu = TarefaUsuario::where('tarefa_id', $tarefaId)->where('user_id', Auth::user()->id)->get();
        return view ('tarefas.gerenciartarefa', compact('tarefa', 'projeto', 'tarefasUsuarios', 'infoUsu'));
    }

    
}
