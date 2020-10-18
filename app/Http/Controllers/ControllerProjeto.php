<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projeto;
use App\Cliente;
use App\StatusProjeto;
use Carbon\Carbon;
class ControllerProjeto extends Controller
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
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataAtual = Carbon::now();
        $dataAtual = (Carbon::parse($dataAtual)->format('yy-m-d'));
        $projetos = Projeto::all();
        return view('projetos.projetos', compact('projetos', 'dataAtual'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $clientes = Cliente::all();

        return view('projetos.novoProjeto', compact('clientes'));
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
        $proj = new Projeto();
        $proj->nome = $request->input('nomeProjeto');
        $proj->descricao = $request->input('descProjeto');
        $proj->cliente_id = $request->input('cliente');
        $proj->tempo_gasto = "00:00:00";
        $proj->data_prevista = $request->input('dataPrevista');
        $proj->status_id = 1;

        $proj->save();
        return redirect('/projetos');
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
        $projeto = Projeto::find($id);
        $clientes = Cliente::all();
        $statusProjetos = StatusProjeto::all();
        if(isset($projeto)){
            return view('projetos.editarProjeto', compact('projeto', 'clientes', 'statusProjetos'));
        }
        return redirect('/projetos');
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
        $projeto = Projeto::find($id);
        if(isset($projeto)){
            $projeto->nome = $request->input('nomeProjeto');
            $projeto->descricao = $request->input('descProjeto');
            $projeto->cliente_id = $request->input('cliente');
            $projeto->tempo_gasto = $projeto->tempo_gasto;
            $projeto->status_id = $request->input('status');
            $projeto->save();
        }
        return redirect('/projetos');
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
        $projeto = Projeto::find($id);
        if(isset($projeto)){
            $projeto->delete();
        }
        return redirect("/projetos");
    }

   
}
