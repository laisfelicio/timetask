<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projeto;
use App\Tarefa;
use Illuminate\Support\Facades\DB;
class ControllerRelatorio extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //PROJETO/STATUS
        $projetoStatus = Projeto::groupBy('status_id')
        ->selectRaw('count(*) as total, status_id')
        ->get();
        $totaisProjetos = $projetoStatus->pluck('total');
        $statusProjetos = $projetoStatus->pluck('status');

        //TAREFAS/STATUS

        $tarefaStatus = Tarefa::groupBy('status_id')
        ->selectRaw('count(*) as total, status_id')
        ->get();
        $totaisTarefas = $tarefaStatus->pluck('total');
        $statusTarefas = $tarefaStatus->pluck('status');

        //TESTE
        $entreguesMes = DB::table('tarefas')
                     ->select(DB::raw("count(*) as total, DATE_FORMAT(data_finalizacao, '%m-%Y') as data"))
                     ->where('finalizado', '=', 1)
                     ->groupBy("data")
                     ->get();
        $totaisEntregues = $entreguesMes->pluck('total');
        $meses = $entreguesMes->pluck('data');

        


        return view('relatorios.relatorio', 
                compact('totaisProjetos', 'statusProjetos', 'statusTarefas', 'totaisTarefas', 
                    'totaisEntregues', 'meses'));
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
    }
}
