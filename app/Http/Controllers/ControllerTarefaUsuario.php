<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projeto;
use App\ProjetoUsuario;
use App\User;
use App\Tarefa;
use App\TarefaUsuario;
use App\StatusTarefa;
use App\Comentario;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use DateTimeZone;
use App\Historico;
use Carbon\CarbonPeriod;
use PDF;

class ControllerTarefaUsuario extends Controller
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
    
    public function index($idProjeto, $idTarefa)
    {
        //
        $projeto = Projeto::find($idProjeto);
        $tarefa = Tarefa::find($idTarefa);
        $usuarios= $projeto->users;
        
        return view('tarefas.alocarusuario', compact('projeto', 'usuarios', 'tarefa'));
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
            'idTarefa' => ['required'],
            'usuario' => ['required', 'unique:tarefa_usuarios,user_id,NULL,id,tarefa_id,' . $request->input('idTarefa')],
        ]);

        $tarefaUsu = new TarefaUsuario();
        $tarefaUsu->tarefa_id = $request->input('idTarefa');
        $tarefaUsu->user_id = $request->input('usuario');
        $tarefaUsu->tempo_gasto = "00:00:00";
        $tarefaUsu->ultimo_start = "1920-01-01 01:00:00";
        $tarefaUsu->ultimo_stop = "1920-01-01 01:00:00";
        $tarefaUsu->save();
        return redirect('/tarefausuario/info/'.$request->input('idProjeto')."/".$request->input('idTarefa'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idProjeto, $idTarefa)
    {
        //
        $tarefa = Tarefa::findOrFail($idTarefa);
        return view('tarefas.info', compact( 'tarefa'));
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
    public function destroy($rota, $id)
    {
        //
        var_dump($rota);
        var_dump($id);
        $tarefaUsuario = TarefaUsuario::find($id);
        var_dump($tarefaUsuario);
        $tarefaId = $tarefaUsuario->tarefa_id;
        $projetoId = Tarefa::find($tarefaId)->projeto_id;

        if(isset($tarefaUsuario)){
            $tarefaUsuario->delete();
        }
        return redirect("/tarefausuario/info/".$projetoId."/".$tarefaId);
    }

    public function getTarefasUsuario(){
        
        date_default_timezone_set('America/Recife');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataAtual = Carbon::now();
        $dataAtual = (Carbon::parse($dataAtual)->format('yy-m-d'));
        $usuarioId = Auth::user()->id;
        $tarefas = Auth::user()->tarefas;
        $tarefas = $this->filtrar($tarefas);
        $statusTarefas = StatusTarefa::all();
        $projetos = Projeto::all();
        return view('tarefas.minhastarefas', compact('tarefas', 'dataAtual', 'statusTarefas', 'projetos'));

    }
    
    public function filtrar($tarefas){

        $dadosFiltrados = $tarefas;

        
        if(request()->has('projeto') && !empty(request('projeto'))){
            
            $dadosFiltrados = $dadosFiltrados->where('projeto_id', request('projeto'));
          
        }

        if(request()->has('statusTarefa') && !empty(request('statusTarefa'))){
            $dadosFiltrados = $dadosFiltrados->where('status_id', request('statusTarefa'));
        }

        if(request()->has('atraso') && !empty(request('atraso'))){
            $dadosFiltrados = $dadosFiltrados->where('emAtraso', request('atraso'))->where('finalizado', 0);

        }
        return $dadosFiltrados;

    }

    public function detalhesTarefa($tarefaId){
        $alocado = TarefaUsuario::where('tarefa_id', $tarefaId)->
                                  where('user_id', Auth::user()->id)->get();
        if(count($alocado) <=0){
            abort(404);
        }                            
        $tarefa = Tarefa::find($tarefaId);
        $projeto = Projeto::find($tarefa->projeto_id);
        $tarefasUsuarios = TarefaUsuario::where('tarefa_id', $tarefaId)->get();
        $infoUsu = TarefaUsuario::where('tarefa_id', $tarefaId)->where('user_id', Auth::user()->id)->first();
        $statusTarefa = StatusTarefa::all();
       
        

        return view ('tarefas.gerenciartarefa', compact('alocado', 'statusTarefa', 'tarefa', 'projeto', 'tarefasUsuarios', 'infoUsu'));
    }

    public function startTimer($tarefaId){
        $usuarioId = Auth::user()->id;
        $tarefaUsu = TarefaUsuario::where('tarefa_id', $tarefaId)->where('user_id', $usuarioId)->first();
        $tarefa = Tarefa::findOrFail($tarefaId);
        date_default_timezone_set('America/Recife');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataHora = Carbon::now();
        
        $tarefaUsu->ultimo_start = Carbon::parse($dataHora)->format('y-m-d H:i:s');
        $this->historicoStart($tarefa, $dataHora);

        $tarefaUsu->save();

        return redirect("/gerenciarTarefa/".$tarefaId);
    }
    
    public function historicoStart(Tarefa $tarefa, $dataHora){

        
        $historico = new Historico();
        $historico->tarefa_id = $tarefa->id;
        $historico->user_id = Auth::user()->id;
        $historico->start = Carbon::parse($dataHora)->format('y-m-d H:i:s');
        $historico->dia = Carbon::parse($dataHora)->format('yy-m-d');
        $historico->save();
    }

    public function historicoStop(Tarefa $tarefa, $dataHora){
        /*$historicosNulos =  Historico::where('user_id', $tarefa->id)->where('tarefa_id', Auth::user()->id)->where('stop', null)->get();
        if(count($historicosNulos) > 0){
            foreach($historicosNulos as $hist){
                if($hist->dia < Carbon::parse($dataHora)->format('yy-m-d')){
                    $hist->stop = $hist->dia.'00:00:00';
                    $hist->save();
                }
                else{

                }
            }
        }*/

        $historicoNulo =  Historico::where('user_id', Auth::user()->id)
                        ->where('tarefa_id', $tarefa->id)
                        ->where('stop', NULL)
                        ->orderBy('id', 'ASC')->get()->first();

        if($historicoNulo->dia < Carbon::parse($dataHora)->format('yy-m-d')){
            $historicoNulo->stop = $historicoNulo->dia.' 23:59:59';
            $historicoNulo->save();
            $periodo = CarbonPeriod::create($historicoNulo->dia, Carbon::parse($dataHora)->format('yy-m-d'));
            $count = count($periodo);
            foreach ($periodo as $key => $data) {
                if($key > 0 && $key < $count -1){
                    
                    $historico = new Historico();
                    $historico->user_id = Auth::user()->id;
                    $historico->tarefa_id = $tarefa->id;
                    $historico->dia = $data->format('Y-m-d');
                    $historico->start = $data->format('Y-m-d').' 00:00:00';
                    $historico->stop = $data->format('Y-m-d').' 23:59:59';
                    $historico->save();
                }
            }

            $historicoHoje = new Historico();
            $historicoHoje->dia = Carbon::parse($dataHora)->format('yy-m-d');
            $historicoHoje->start = Carbon::parse($dataHora)->format('yy-m-d').' 00:00:00';
            $historicoHoje->stop = Carbon::parse($dataHora)->format('y-m-d H:i:s');
            $historicoHoje->user_id = Auth::user()->id;
            $historicoHoje->tarefa_id = $tarefa->id;
            $historicoHoje->save();
        }
        else
        {
            $historicoNulo->stop = Carbon::parse($dataHora)->format('y-m-d H:i:s');
            $historicoNulo->save();
        }

        
   
    }
    public function stopTimer($tarefaId){
        $usuarioId = Auth::user()->id;
        $tarefaUsu = TarefaUsuario::where('tarefa_id', $tarefaId)->where('user_id', $usuarioId)->first();
        $tarefa = Tarefa::findOrFail($tarefaId);
        date_default_timezone_set('America/Recife');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataHora = Carbon::now();
        
      
        $this->historicoStop($tarefa, $dataHora);
        $tarefaUsu->ultimo_stop = Carbon::parse($dataHora)->format('y-m-d H:i:s');
        $tarefaUsu->save();

        $fim = Carbon::parse($tarefaUsu->ultimo_stop);
        $inicio = Carbon::parse($tarefaUsu->ultimo_start);
        $total = $inicio->diffInHours($fim) . ':' . $inicio->diff($fim)->format('%I:%S');

        $tarefa = Tarefa::find($tarefaId);
        $projeto = Projeto::find($tarefa->projeto_id);
        $total_horas_projeto = $this->somaHoras($total,$projeto->tempo_gasto);
        $projeto->tempo_gasto = $total_horas_projeto;
        $projeto->save();
        $tarefa->tempo_gasto = $this->somaHoras($total,$tarefa->tempo_gasto);
        $tarefa->save();

        $tarefaUsu->tempo_gasto = $this->somaHoras($total,$tarefaUsu->tempo_gasto);
        $tarefaUsu->save();

        $projetoUso = ProjetoUsuario::where('projeto_id', $projeto->id)->where('user_id', $usuarioId)->first();
        $total_horas_projeto_usuario = $this->somaHoras($total,$projetoUso->tempo_total);
        $projetoUso->tempo_total =  $total_horas_projeto_usuario;
        $projetoUso->save();

        return redirect("/gerenciarTarefa/".$tarefaId);

    }

    public function somaHoras($antiga, $nova){
        
        $tempo1 = explode(":", $antiga);
        $tempo2 = explode(":", $nova);

        var_dump($nova);
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

    public function gerenciar(Request $request){
        date_default_timezone_set('America/Recife');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataHora = Carbon::now();

        $tarefa = Tarefa::find($request->idTarefa);
        if($request->statusTarefa == 4){
            $tarefa->finalizado = 1;
            $tarefa->data_finalizacao = Carbon::parse($dataHora)->format('y-m-d H:i:s');
        }
        else{
            $tarefa->finalizado = 0;
            $tarefa->data_finalizacao =null;
        }
        $tarefa->nome = $request->nomeTarefa;
        $tarefa->status_id = $request->statusTarefa;
        $tarefa->save();
        return redirect("/gerenciarTarefa/".$request->idTarefa);
    }

    public function downloadRelatorio(Request $request){
     
        
        //$dados = (Collect(json_decode(rawurldecode($request->clientes))));
        $dados = (Collect(json_decode($request->tarefas)));
   
        
        $html = '<h1> Relatório - Tarefas </h1>';
        
   
       foreach($dados as $dado){
                $html = $html. '<table cellspacing="0" cellpadding="1" border="1">   
                <tr style="background-color:#D9A5F3;color:#FFFFFF;">
                <td>ID</td>
                <td colspan="2">NOME</td>
                <td colspan="2">PROJETO</td>
                <td colspan="2">DESCRICAO</td>
                </tr>';
                $html = $html.'<tr>';
                $html = $html.'<td> '.$dado->id . '</td> ';
                $html = $html.'<td colspan="2"> '.$dado->nome . '</td> ';
                $html = $html.'<td colspan="2"> '.$dado->projeto->nome . '</td> ';
                $html = $html.'<td colspan="2"> '.$dado->descricao . '</td> ';

                $html = $html.'</tr>';
                $html = $html. '
                </table> <br> <hr>'; 

                $html = $html. '<table cellspacing="0" cellpadding="1" border="1">   
                <tr style="background-color:#D9A5F3;color:#FFFFFF;">
                <td colspan="2">DATA PREVISTA</td>
                <td colspan="2">TEMPO PREVISTO</td>
                <td colspan="2">TEMPO GASTO</td>
                </tr>';
                $html = $html.'<tr>';
                $html = $html.'<td colspan="2"> '.$dado->data_prevista . '</td> ';
                $html = $html.'<td colspan="2"> '.$dado->tempo_previsto . '</td> ';
                $html = $html.'<td colspan="2"> '.$dado->tempo_gasto . '</td> ';

                $html = $html.'</tr>';
                $html = $html. '
                </table> <br> <hr>'; 

                $html = $html. '<table cellspacing="0" cellpadding="1" border="1">   
                <tr style="background-color:#D9A5F3;color:#FFFFFF;">
                <td colspan="2">STATUS</td>
                <td colspan="2">FINALIZADO?</td>
                <td colspan="2">DATA FINALIZAÇÃO</td>
                </tr>';
                $html = $html.'<tr>';
                $html = $html.'<td colspan="2"> '.$dado->status->nome . '</td> ';
                if(isset($dado->finalizado) && $dado->finalizado == 1){
                    $html = $html.'<td colspan="2"> '.'SIM' . '</td> ';
                    $html = $html.'<td colspan="2"> '.$dado->data_finalizacao . '</td> ';
                }
                else{
                    $html = $html.'<td colspan="2"> '.'NAO' . '</td> ';
                    $html = $html.'<td colspan="2"> '.'-' . '</td> ';
                }

                $html = $html.'</tr>';
                $html = $html. '
                </table> <br> <hr>'; 

                $usuarios = TarefaUsuario::where('tarefa_id', $dado->id)->get();

                $html = $html.'<h2> Usuários </h2>';
                
                $html = $html. '<table cellspacing="0" cellpadding="1" border="1">   
                <tr style="background-color:#D9A5F3;color:#FFFFFF;">
                <td colspan="2">USUARIO</td>
                <td colspan="2">TEMPO GASTO</td>
                </tr>';
                if(count($usuarios) > 0){
                    foreach($usuarios as $usuario){
                        $user = User::findOrFail($usuario->user_id);
                        $html = $html.'<tr>';
                        $html = $html.'<td colspan="2"> '.$user->name . '</td> ';
                        $html = $html.'<td colspan="2"> '.$usuario->tempo_gasto . '</td> ';

                        $html = $html.'</tr>';
    

                    }
                }

                $html = $html. '
                </table> <br> <hr>';    
 
               PDF::AddPage();
               
               PDF::writeHTML($html, true, false, true, false, '');
               $html = "";
       }   
   
         
       
       PDF::SetTitle('Relatório - Tarefas');
       PDF::AddPage();
       
   
       PDF::Output('relatorio_tarefa.pdf');
           
   
    }

    
}
