<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProjetoUsuario;
use App\Projeto;
use App\Tarefa;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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
        $validatedData = $request->validate([
            'idProjeto' => ['required'],
            'usuario' => ['required', 'unique:projeto_usuarios,user_id,NULL,id,projeto_id,' . $request->input('idProjeto')],
        ]);


        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataAtual = Carbon::now();
        $dataAtual = (Carbon::parse($dataAtual)->format('yy-m-d'));
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
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataAtual = Carbon::now();
        $dataAtual = (Carbon::parse($dataAtual)->format('yy-m-d'));
        $alocados= ProjetoUsuario::where('projeto_id', $id)->get();
        $projeto = Projeto::find($id);
        $tarefas = Tarefa::where('projeto_id', $id)->get();
        return view('projetos.info', compact('alocados', 'projeto', 'tarefas', 'dataAtual'));
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

    public function getProjetoUsuario(){
        
        $usuarioId = Auth::user()->id;
        $projetos = ProjetoUsuario::where('user_id', $usuarioId)->get();
        return view('projetos.meusprojetos', compact('projetos'));

    }
}
