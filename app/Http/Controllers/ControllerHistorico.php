<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Historico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
class ControllerHistorico extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $historicos = Historico::where('user_id', Auth::user()->id)->get();
        return view('historico.meuhistorico', compact('historicos'));

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
        $historico = Historico::findOrFail($id);
        return view('historico.editarHistorico', compact('historico'));
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
        $historico = Historico::findOrFail($id);
        $dia = Carbon::parse($request->dia)->format('yy-m-d');
        if(isset($historico)){
            $historico->start = $dia." ".Carbon::parse($request->horaInicio)->format('H:i:s');
            $historico->stop = $dia." ".Carbon::parse($request->horaFim)->format('H:i:s');
            $historico->save();
        }
        return redirect('/timesheet');
       
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
