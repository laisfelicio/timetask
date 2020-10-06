<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StatusTarefa;

class ControllerStatusTarefa extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $statusTarefas = StatusTarefa::all();
        return view('statusTarefas.statusTarefa', compact('statusTarefas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('statusTarefas.novoStatusTarefa');
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
        $statusTarefa = new StatusTarefa();
        $statusTarefa->nome = $request->input('nomeStatus');
        $statusTarefa->save();
        return redirect('/statustarefa');
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
        $status = StatusTarefa::find($id);
        if(isset($status)){
            return view('statusTarefas.editarStatusTarefa', compact('status'));
        }
        return redirect('/statustarefa');
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
        $statusTarefa = StatusTarefa::find($id);
        if(isset($statusTarefa)){
            $statusTarefa->nome = $request->input('nomeStatus');
            $statusTarefa->save();
        }
        return redirect('/statustarefa');
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
        $status = StatusTarefa::find($id);
        if(isset($status)){
            $status->delete();
        }
        return redirect("/statustarefa");
    }
}
