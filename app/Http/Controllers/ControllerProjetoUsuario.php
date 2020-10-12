<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProjetoUsuario;
use App\Projeto;
use App\User;
class ControllerProjetoUsuario extends Controller
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
    
    public function index($id)
    {
        //
        $projeto = Projeto::find($id);
        $usuarios = User::all();
        return view('projetos.alocarUsuario', compact('projeto', 'usuarios'));
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
        $projUsu = new ProjetoUsuario();
        $projUsu->projeto_id = $request->input('idProjeto');
        $projUsu->user_id = $request->input('usuario');
        $projUsu->tempo_total = "00:00:00";
        $projUsu->save();
        return redirect('/projetousuario/info/'.$request->input('idProjeto'));
    }

    /**
     * Dis6play the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $alocados= ProjetoUsuario::where('projeto_id', $id)->get();
        $projeto = Projeto::find($id);
        return view('projetos.info', compact('alocados', 'projeto'));
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
    public function destroy($id)
    {
        //
        
        $projUsu = ProjetoUsuario::find($id);
        $projetoId = $projUsu->projeto_id;
        if(isset($projUsu)){
            $projUsu->delete();
        }
        return redirect("/projetousuario/info/".$projetoId);
        
    }
}
