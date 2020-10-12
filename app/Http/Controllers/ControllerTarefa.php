<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarefa;
use App\Projeto;
use App\StatusProjeto;
use App\User;

class ControllerTarefa extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //
        //$tarefas = Tarefa::all();
        $tarefas = Tarefa::all();
        return view('tarefas.tarefas', compact('tarefas'));
    }

    public function alocar($id){

        $tarefa = Tarefa::find($id);
        $usuarios = User::all();
        return view('tarefas.alocarUsuario', compact('tarefa', 'usuarios'));
    }

    public function salvaAlocacao(Request $request){
        //return TarefaUsuarios::where('tarefa_id', $id)->get()->toJson();

    }

    public function info(){

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $projetos = Projeto::all();

        return view('tarefas.novaTarefa', compact('projetos'));
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
        $tarefa = new Tarefa();
        $tarefa->nome = $request->input('nomeTarefa');
        $tarefa->descricao = $request->input('descTarefa');
        $tarefa->tempo_previsto = $request->input('tempoPrevisto');
        $tarefa->projeto_id = $request->input('projeto');
        $tarefa->status_id = 1;
        $tarefa->save();
        return redirect('/tarefas');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        $tarefa = Tarefa::find($id);
        $projetos = Projeto::all();
        $statusTarefas = StatusProjeto::all();
        if(isset($tarefa)){
            return view('tarefas.editarTarefa', compact('tarefa', 'projetos', 'statusTarefas'));
        }
        return redirect('/tarefas');
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
        $tarefa = Tarefa::find($id);
        if(isset($tarefa)){
            $tarefa->nome = $request->input('nomeTarefa');
            $tarefa->descricao = $request->input('descTarefa');
            $tarefa->projeto_id = $request->input('projeto');
            $tarefa->status_id = $request->input('status');
            $tarefa->save();
        }
        return redirect('/tarefas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $tarefa = Tarefa::find($id);
        if(isset($tarefa)){
            $tarefa->delete();
        }
        return redirect("/tarefas");
    }
}
