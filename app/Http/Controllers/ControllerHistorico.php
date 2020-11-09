<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Historico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use PDF;
use App\Tarefa;
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
        $historicos = Historico::where('user_id', Auth::user()->id)->orderBy('dia', 'ASC')->get();
        return view('historico.meuhistorico', compact('historicos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('historico.novohistorico');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $historico = new Historico();
        $dia = Carbon::parse($request->dia)->format('yy-m-d');
        $historico->start = $dia." ".Carbon::parse($request->horaInicio)->format('H:i:s');
        $historico->stop = $dia." ".Carbon::parse($request->horaFim)->format('H:i:s');
        $historico->dia = $dia;
        $historico->tarefa_id = $request->tarefa;
        $historico->user_id = Auth::user()->id;
        $historico->save();
        return redirect('/timesheet');
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

    public function downloadRelatorio(Request $request){
     
        
        //$dados = (Collect(json_decode(rawurldecode($request->clientes))));
        $dados = (Collect(json_decode($request->historicos)));
        
        PDF::AddPage();
        $html = '<h1> Relatório - Horários </h1>';
        $html = $html. '<table cellspacing="0" cellpadding="1" border="1">   
                <tr style="background-color:#D9A5F3;color:#FFFFFF;">
                <td colspan="1">ID TAREFA</td>
                <td colspan="2">TAREFA</td>
                <td colspan="2">DIA</td>
                <td colspan="2">HORAS</td>
                </tr>';
   
       foreach($dados as $dado){
                
                $html = $html.'<tr>';
                $html = $html.'<td colspan="1"> '.$dado->tarefa_id . '</td> ';
                $html = $html.'<td colspan="2"> '.$dado->nomeTarefa . '</td> ';
                $dia = Carbon::parse($dado->dia)->format('d/m/Y');
                $html = $html.'<td colspan="2"> '.$dia . '</td> ';
                $html = $html.'<td colspan="2"> '.$dado->horas . '</td> ';

                $html = $html.'</tr>';
               

 
               
               
               
       }   
   
       $html = $html. '
       </table> <br> <hr>'; 
       PDF::writeHTML($html, true, false, true, false, '');
               $html = "";
         
       
       PDF::SetTitle('Relatório - Horas');
       PDF::AddPage();
       
   
       PDF::Output('relatorio_horas.pdf');
   
    }
}
