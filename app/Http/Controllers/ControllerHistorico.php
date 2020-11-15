<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Historico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use PDF;
use App\Tarefa;
use App\Projeto;
use App\TarefaUsuario;
use App\ProjetoUsuario;
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
        $historicos = Historico::where('user_id', Auth::user()->id);
        $historicos = $this->filtrar($historicos);
        $projetos = Auth::user()->projetos;
        $tarefas = Auth::user()->tarefas;
        return view('historico.meuhistorico', compact('historicos', 'projetos', 'tarefas'));

    }

    public function filtrar($historicos){
        
        $historicosFiltrados = $historicos;
        if(request()->has('dataInicio') && !empty(request('dataInicio'))){
            
            $historicosFiltrados = $historicosFiltrados->whereDate('dia', '>=', request('dataInicio'));
        }

        if(request()->has('dataFim') && !empty(request('dataFim'))){
            
            $historicosFiltrados = $historicosFiltrados->whereDate('dia', '<=', request('dataFim'));
        }


        if(request()->has('tarefa') && !empty(request('tarefa'))){
            $historicosFiltrados = $historicosFiltrados->where('tarefa_id', request('tarefa'));
        }

        
        return $historicosFiltrados->orderBy('dia', 'ASC')->get();
        
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

        $fim = Carbon::parse($dia." ".Carbon::parse($historico->start)->format('H:i:s'));
        $inicio = Carbon::parse($dia." ".Carbon::parse($historico->stop)->format('H:i:s'));
        $qtdHoras = $inicio->diffInHours($fim) . ':' . $inicio->diff($fim)->format('%I:%S');
        $tarefa = Tarefa::findOrFail($request->tarefa);
        $projeto = Projeto::find($tarefa->projeto_id);
        $projeto->tempo_gasto = $this->somaHoras($projeto->tempo_gasto, $qtdHoras);
        $projeto->save();

        
        $tarefa->tempo_gasto = $this->somaHoras($tarefa->tempo_gasto, $qtdHoras);
        $tarefa->save();

        $tarefaUsuario = TarefaUsuario::where('user_id', Auth::user()->id)
                        ->where('tarefa_id', $tarefa->id)->get()->first();
        $tarefaUsuario->tempo_gasto = $this->somaHoras($tarefaUsuario->tempo_gasto, $qtdHoras);
        
        $tarefaUsuario->save();
        $projetoUsuario = ProjetoUsuario::where('user_id', Auth::user()->id)
                        ->where('projeto_id', $tarefa->projeto_id)->get()->first();
        
        $projetoUsuario->tempo_total = $this->somaHoras($projetoUsuario->tempo_total, $qtdHoras);
        
        $projetoUsuario->save();
        
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
        $fim = Carbon::parse($request->horaInicio);
        $inicio = Carbon::parse($request->horaFim);
        $totalAtualizado = $inicio->diffInHours($fim) . ':' . $inicio->diff($fim)->format('%I:%S');
        $totalAtualizado = Carbon::parse($totalAtualizado)->format('H:i:s');
        $historico = Historico::findOrFail($id);
        $totalAtual = Carbon::parse($historico->horas)->format('H:i:s');

        if($totalAtual > $totalAtualizado){
            $t1 = Carbon::parse($historico->horas);
            
            $diferenca = $t1->diffInHours($totalAtualizado) . ':' . $t1->diff($totalAtualizado)->format('%I:%S');
            $projeto = Projeto::find($historico->tarefa->projeto_id);     
            $projeto->tempo_gasto = $this->subtraiHoras($projeto->tempo_gasto, $diferenca);
            $projeto->save();

            $tarefa = $historico->tarefa;
            $tarefa->tempo_gasto = $this->subtraiHoras($tarefa->tempo_gasto, $diferenca);
            $tarefa->save();

            $tarefaUsuario = TarefaUsuario::where('user_id', Auth::user()->id)
                        ->where('tarefa_id', $tarefa->id)->get()->first();
            $tarefaUsuario->tempo_gasto = $this->subtraiHoras($tarefaUsuario->tempo_gasto, $diferenca);

            $projetoUsuario = ProjetoUsuario::where('user_id', Auth::user()->id)
                        ->where('projeto_id', $tarefa->projeto_id)->get()->first();
            $tempoGasto = Carbon::parse($projetoUsuario->tempo_total);
            $projetoUsuario->tempo_total = $this->subtraiHoras($projetoUsuario->tempo_total, $diferenca);
            $projetoUsuario->save();
            
        }
        else
        {
            if($totalAtual < $totalAtualizado)
            {
                $t1 = Carbon::parse($historico->horas);
            
                $diferenca = $t1->diffInHours($totalAtualizado) . ':' . $t1->diff($totalAtualizado)->format('%I:%S');
                
                $projeto = Projeto::find($historico->tarefa->projeto_id);
                $projeto->tempo_gasto = $this->somaHoras($projeto->tempo_gasto, $diferenca);
                $projeto->save();
    
                $tarefa = $historico->tarefa;
                $tarefa->tempo_gasto = $this->somaHoras($tarefa->tempo_gasto, $diferenca);
                $tarefa->save();

                $tarefaUsuario = TarefaUsuario::where('user_id', Auth::user()->id)
                            ->where('tarefa_id', $tarefa->id)->get()->first();
                $tempoGasto = Carbon::parse($tarefaUsuario->tempo_gasto);
                $tarefaUsuario->tempo_gasto = $this->somaHoras($tarefaUsuario->tempo_gasto, $diferenca);
                $tarefaUsuario->save();
                $projetoUsuario = ProjetoUsuario::where('user_id', Auth::user()->id)
                            ->where('projeto_id', $tarefa->projeto_id)->get()->first();
                $tempoGasto = Carbon::parse($projetoUsuario->tempo_total);
                $projetoUsuario->tempo_total = $this->somaHoras($projetoUsuario->tempo_gasto, $diferenca);
                $projetoUsuario->save();

            }
            else{
                return redirect('/timesheet');
            }
        }
        
        $dia = Carbon::parse($request->dia)->format('yy-m-d');
        if(isset($historico)){
            $historico->start = $dia." ".Carbon::parse($request->horaInicio)->format('H:i:s');
            $historico->stop = $dia." ".Carbon::parse($request->horaFim)->format('H:i:s');
            $historico->save();
        }
        return redirect('/timesheet');
       
    }

    public function somaHoras($antiga, $nova){
        
        $tempo1 = explode(":", $antiga);
        $tempo2 = explode(":", $nova);
        

        
        $totalSecs = 0;
        $totalSecs += $tempo1[0] * 3600;
        $totalSecs += $tempo1[1] * 60;
        $totalSecs += $tempo1[2];
        $totalSecs += $tempo2[0] * 3600;
        $totalSecs += $tempo2[1] * 60;
        $totalSecs += $tempo2[2];

        $hora = intdiv($totalSecs,3600);
        $hora = str_pad($hora, 3, "0", STR_PAD_LEFT);
        $min = intdiv(($totalSecs%3600),60);
        $min = str_pad($min, 2, "0", STR_PAD_LEFT);
        $sec = ($totalSecs%3600)%60;
        $sec = str_pad($sec, 2, "0", STR_PAD_LEFT);
        return $hora.":".$min.":".$sec;
    }

    public function subtraiHoras($horaMaior, $horaMenor){
        var_dump($horaMaior);
        echo ("HORA MENOR = ".$horaMenor);
        $maior = explode(":", $horaMaior);
        $menor = explode(":", $horaMenor);

        $maiorSecs = 0;
        $maiorSecs += $maior[0] * 3600;
        $maiorSecs += $maior[1] * 60;
        $maiorSecs += $maior[2]; 

        $menorSecs = 0;
        $menorSecs += $menor[0] * 3600;
        $menorSecs += $menor[1] * 60;
        $menorSecs += $menor[2]; 

        $total = $maiorSecs - $menorSecs;
        $hora = intdiv($total,3600);
        $hora = str_pad($hora, 3, "0", STR_PAD_LEFT);
        $min = intdiv(($total%3600),60);
        $min = str_pad($min, 2, "0", STR_PAD_LEFT);
        $sec = ($total%3600)%60;
        $sec = str_pad($sec, 2, "0", STR_PAD_LEFT);

        dd($hora.":".$min.":".$sec);
        return $hora.":".$min.":".$sec;
        

        


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
