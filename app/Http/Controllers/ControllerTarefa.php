<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarefa;
use App\Projeto;
use App\StatusProjeto;
use App\TarefaUsuario;
use App\User;
use App\Cliente;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
class ControllerTarefa extends Controller
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
        //$tarefas = Tarefa::all();

        if(Auth::user()->admin == 0){
            abort(404);
        }

        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataAtual = Carbon::now();
        $dataAtual = (Carbon::parse($dataAtual)->format('yy-m-d'));
        $tarefas = Tarefa::all();
        return view('tarefas.tarefas', compact('tarefas', 'dataAtual'));
    }

    public function alocar($id){

        $tarefa = Tarefa::find($id);
        $usuarios = User::all();
        return view('tarefas.alocarUsuario', compact('tarefa', 'usuarios'));
    }

    public function salvaAlocacao(Request $request){
        //return TarefaUsuarios::where('tarefa_id', $id)->get()->toJson();

    }

    public function info(){

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $projetos = Projeto::all();

        return view('tarefas.novaTarefa', compact('projetos'));
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
        $tarefa = new Tarefa();
        $tarefa->nome = $request->input('nomeTarefa');
        $tarefa->descricao = $request->input('descTarefa');
        $tarefa->tempo_previsto = $request->input('tempoPrevisto');
        $tarefa->projeto_id = $request->input('projeto');
        $tarefa->status_id = 1;
        $tarefa->data_prevista = $request->input('dataPrevista');
        $tarefa->tempo_gasto = "00:00:00";
        $tarefa->save();
        return redirect('/tarefas');
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

        $tarefa = Tarefa::find($id);
        $projetos = Projeto::all();
        $statusTarefas = StatusProjeto::all();
        if(isset($tarefa)){
            return view('tarefas.editarTarefa', compact('tarefa', 'projetos', 'statusTarefas'));
        }
        return redirect('/tarefas');
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
        date_default_timezone_set('America/Recife');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataHora = Carbon::now();
        $tarefa = Tarefa::find($id);
        if(isset($tarefa)){
            if($request->status == 4){
                $tarefa->finalizado = 1;
                $tarefa->data_finalizacao = Carbon::parse($dataHora)->format('y-m-d H:i:s');
            }
            else{
                $tarefa->finalizado = 0;
                $tarefa->data_finalizacao =null;
            }
            $tarefa->nome = $request->input('nomeTarefa');
            $tarefa->descricao = $request->input('descTarefa');
            $tarefa->projeto_id = $request->input('projeto');
            $tarefa->status_id = $request->input('status');
            $tarefa->data_prevista = $request->input('dataPrevista');
            $tarefa->tempo_previsto = $request->input('tempoPrevisto');
            $tarefa->save();
        }
        return redirect('/tarefas');
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
        $tarefa = Tarefa::find($id);
        $this->deletaDependentes($id);
        if(isset($tarefa)){
            $tarefa->delete();
        }
        return redirect("/tarefas");
    }

    public function deletaDependentes($tarefaId){
        $tarefaUsuario = TarefaUsuario::where('tarefa_id', $tarefaId)->get();
        foreach($tarefaUsuario as $taUsu){
            $taUsu->delete();
        }
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
                $html = $html.'<td colspan="2"> '.$dado->projeto . '</td> ';
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
                $html = $html.'<td colspan="2"> '.$dado->status . '</td> ';
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
                        $html = $html.'<tr>';
                        $html = $html.'<td colspan="2"> '.$usuario->nomeUsuario . '</td> ';
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
  

