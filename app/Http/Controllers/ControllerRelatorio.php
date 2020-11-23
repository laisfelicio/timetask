<?php

namespace App\Http\Controllers;

use App\User;
use App\Tarefa;
use App\TarefaUsuario;
use App\Projeto;
use App\ProjetoUsuario;
use App\Historico;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Carbon;

class ControllerRelatorio extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('relatorios.relatoriospdf');
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

    public function indexUsuarioHora(){
        $usuarios = User::all();
        return view('relatorios.usuarioshoras', compact('usuarios'));
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


    public function filtrar($historico){

        $historicosFiltrados = $historico;

        
        if(request()->has('usuario') && !empty(request('usuario'))){
            
            $historicosFiltrados = $historicosFiltrados->where('user_id', request('usuario'));
            
          
        }

        if(request()->has('dataInicio') && !empty(request('dataInicio'))){
            
            $historicosFiltrados = $historicosFiltrados->whereDate('dia', '>=', request('dataInicio'));
        }

        if(request()->has('dataFim') && !empty(request('dataFim'))){
            
            $historicosFiltrados = $historicosFiltrados->whereDate('dia', '<=', request('dataFim'));
        }
        return $historicosFiltrados->orderBy('user_id', 'ASC')->orderBy('dia', 'ASC')->get();

    }

    public function filtrarProjetos($historico){

        $historicosFiltrados = $historico;
        
        $historicosFiltrados = $historicosFiltrados
                                    ->whereHas('tarefa', function ($q) { 
                                        $q->orderBy('projeto_id', 'ASC');
                                    });
            

        
        if(request()->has('projeto') && !empty(request('projeto'))){
            
            $historicosFiltrados = $historicosFiltrados
                                    ->whereHas('tarefa', function ($q) { 
                                        $q->where('projeto_id', request('projeto'))->orderBy('projeto_id', 'ASC');
                                    });
        }

        if(request()->has('dataInicio') && !empty(request('dataInicio'))){
            
            $historicosFiltrados = $historicosFiltrados->whereDate('dia', '>=', request('dataInicio'));
        }

        if(request()->has('dataFim') && !empty(request('dataFim'))){
            
            $historicosFiltrados = $historicosFiltrados->whereDate('dia', '<=', request('dataFim'));
        }


        return $historicosFiltrados->get();

    }



    public function downloadUsuarioHora(Request $request){
        
        $historicos =Historico::where('id', '>', 0);
        $historicos = $this->filtrar($historicos);
      
        
        PDF::AddPage();

   
        $somaHoras = "00:00:00";
        $idUser = 0;
        $idUserAnt = 0;
        $html = "";
        $count = count($historicos);

       foreach($historicos as $key => $historico){
                if($key == 0){
                    $html = $html.'<h1> Relatório - Usuários x Hora </h1>';
                    $html = $html.'<h3> <b> Usuário: '.$historico->user->name.'</b></h3>';
                    $html = $html. '<table cellspacing="0" cellpadding="1" border="1">   
                            <tr style="background-color:#D9A5F3;color:#FFFFFF;">
                            <td colspan="1">ID TAREFA</td>
                            <td colspan="2">TAREFA</td>
                            <td colspan="2">USUARIO</td>
                            <td colspan="2">DIA</td>
                            <td colspan="2">HORAS</td>
                            </tr>';
                    $somaHoras = $this->somaHoras($somaHoras, $historico->horas);
                    $idUserAnt = $historico->user_id;
                    $html = $html.'<tr>';
                    $html = $html.'<td colspan="1"> '.$historico->tarefa_id . '</td> ';
                    $html = $html.'<td colspan="2"> '.$historico->tarefa->nome . '</td> ';
                    $html = $html.'<td colspan="2"> '.$historico->user->name . '</td> ';
                    $dia = Carbon::parse($historico->dia)->format('d/m/Y');
                    $html = $html.'<td colspan="2"> '.$dia . '</td> ';
                    $html = $html.'<td colspan="2"> '.$historico->horas . '</td> ';

                    $html = $html.'</tr>';

                    if($key == $count - 1){
                        $html = $html. '
                        </table> <br> <hr>'; 
                        $html = $html. 'TOTAL DE HORAS = '.$somaHoras;
                        PDF::writeHTML($html, true, false, true, false, '');
                    }
                    
                    
                }
                else{

                    
                        if($idUserAnt <> $historico->user_id){
                            $html = $html. '
                            </table> <br> <hr>'; 
                            $html = $html. 'TOTAL DE HORAS = '.$somaHoras;
                            $somaHoras = "00:00:00";
                            $idUserAnt = $historico->user_id;
                            PDF::writeHTML($html, true, false, true, false, '');
                            PDF::AddPage();
                            $html = "";
                            $html = $html.'<h1> Relatório - Usuários x Hora </h1>';
                            $html = $html.'<h3> <b> Usuário: '.$historico->user->name.'</b></h3>';
                            $html = $html. '<table cellspacing="0" cellpadding="1" border="1">   
                                    <tr style="background-color:#D9A5F3;color:#FFFFFF;">
                                    <td colspan="1">ID TAREFA</td>
                                    <td colspan="2">TAREFA</td>
                                    <td colspan="2">USUARIO</td>
                                    <td colspan="2">DIA</td>
                                    <td colspan="2">HORAS</td>
                                    </tr>';
                                $somaHoras = $this->somaHoras($somaHoras, $historico->horas);
                                $html = $html.'<tr>';
                                $html = $html.'<td colspan="1"> '.$historico->tarefa_id . '</td> ';
                                $html = $html.'<td colspan="2"> '.$historico->tarefa->nome . '</td> ';
                                $html = $html.'<td colspan="2"> '.$historico->user->name . '</td> ';
                                $dia = Carbon::parse($historico->dia)->format('d/m/Y');
                                $html = $html.'<td colspan="2"> '.$dia . '</td> ';
                                $html = $html.'<td colspan="2"> '.$historico->horas . '</td> ';
                                $html = $html.'</tr>';

                                if($key == $count - 1){
                                    $html = $html. '
                                    </table> <br> <hr>'; 
                                    $html = $html. 'TOTAL DE HORAS = '.$somaHoras;
                                    PDF::writeHTML($html, true, false, true, false, '');
                                }
                    
                        }
                        else{
                            $somaHoras = $this->somaHoras($somaHoras, $historico->horas);
                            $html = $html.'<tr>';
                            $html = $html.'<td colspan="1"> '.$historico->tarefa_id . '</td> ';
                            $html = $html.'<td colspan="2"> '.$historico->tarefa->nome . '</td> ';
                            $html = $html.'<td colspan="2"> '.$historico->user->name . '</td> ';
                            $dia = Carbon::parse($historico->dia)->format('d/m/Y');
                            $html = $html.'<td colspan="2"> '.$dia . '</td> ';
                            $html = $html.'<td colspan="2"> '.$historico->horas . '</td> ';
                            $html = $html.'</tr>';

                            if($key == $count - 1){
                                $html = $html. '
                                </table> <br> <hr>'; 
                                $html = $html. 'TOTAL DE HORAS = '.$somaHoras;
                                PDF::writeHTML($html, true, false, true, false, '');
                            }
                        }
                    
                }        
               
       }   
 
       
       PDF::SetTitle('Relatório - Horas');
       
   
       PDF::Output('relatorio_horas.pdf');

    }
    public function downloadProjetoHora(Request $request){
        
        
        $somaHoras = "00:00:00";
        $html = "";

        $projetos = Projeto::where('id', '>', 0);
        if(request()->has('projeto') && !empty(request('projeto'))){
            
            $projetos->where('id', request('projeto'))->first();
        }

        
        foreach($projetos->get() as $projeto){
            
            PDF::AddPage();
            $html = "";
            $somaHoras = "00:00:00";
            $html = $html.'<h1> Relatório - Projetos x Hora </h1>';
            $html = $html.'<h2><i>'.$projeto->id." - ".$projeto->nome.'</h2></i>';
            $html = $html. '<table cellspacing="0" cellpadding="1" border="1">   
                    <tr style="background-color:#D9A5F3;color:#FFFFFF;">
                    <td colspan="1">ID TAREFA</td>
                    <td colspan="2">NOME TAREFA</td>
                    <td colspan="2">DIA</td>
                    <td colspan="2">HORAS</td>
                    <td colspan="2">USUARIO</td>
                    </tr>';
            
            $countTarefas = 0;
            $countTarefas = count($projeto->tarefasTrashed);
            if($countTarefas == 0){
                $html = $html. '
                    </table> <br> <hr>'; 
                    $html = $html. 'TOTAL DE HORAS = '.$somaHoras;
                    PDF::writeHTML($html, true, false, true, false, '');   
                continue;                         
            }  
            
            foreach($projeto->tarefasTrashed as $tarefa){  
                $count = 0;
                $count = count($tarefa->historicos);  
                if($count == 0){
                        continue;                            
                } 
                $historicos = $tarefa->historicos;

                if(request()->has('dataInicio') && !empty(request('dataInicio'))){
            
                    $dataInicio = request('dataInicio');                       
                    $historicos = $historicos->filter(function($historico) use ($dataInicio){
                        //return $historico->dia >= $dataInicio;
                        return data_get($historico, 'dia') >= $dataInicio;
                    });
                }
                
                if(request()->has('dataFim') && !empty(request('dataFim'))){  
                    $dataFim = request('dataFim');                     
                    $historicos = $historicos->filter(function($historico) use ($dataFim){
                        return Carbon::parse($historico->dia)->format('Y-m-d') <= $dataFim;
                    });
                } 
                
                

                foreach($historicos->sortBy('dia') as $historico){
                    $somaHoras = $this->somaHoras($somaHoras, $historico->horas);
                    $html = $html.'<tr>';
                    $html = $html.'<td colspan="1"> '.$historico->tarefa->id . '</td> ';
                    $html = $html.'<td colspan="2"> '.$historico->tarefa->nome . '</td> ';
                    $dia = Carbon::parse($historico->dia)->format('d/m/Y');
                    $html = $html.'<td colspan="2"> '.$dia . '</td> ';
                    $html = $html.'<td colspan="2"> '.$historico->horas . '</td> ';
                    $html = $html.'<td colspan="2"> '.$historico->user->name . '</td> ';
                    $html = $html.'</tr>';                                        
                }
            
            }
            $html = $html. '
                        </table> <br> <hr>'; 
                        $html = $html. 'TOTAL DE HORAS = '.$somaHoras;
                        PDF::writeHTML($html, true, false, true, false, '');
            
        }

        
        PDF::SetTitle('Relatório - Projetos x Horas');
        PDF::Output('relatorio_projetos_horas.pdf');

    }

    public function indexProjetoHora(){
        $projetos = Projeto::all();
        return view('relatorios.projetohoras', compact('projetos'));
    }

    public function indexUsuarioProjetoHora(){
        $usuarios = User::all();
        $projetos = Projeto::all();
        return view('relatorios.usuarioprojetohoras', compact('usuarios', 'projetos'));
    }

    public function downloadUsuarioProjetoHora(Request $request){
        

    }
}
