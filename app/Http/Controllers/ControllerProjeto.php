<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projeto;
use App\Cliente;
use App\ProjetoUsuario;
use App\StatusProjeto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Tarefa;
use App\User;
use App\TarefaUsuario;
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
        
        if(Auth::user()->admin == 0){
            abort(404);
        }
        $projetos = Projeto::all();
        $projetos = $this->filtrar($projetos);
        
        date_default_timezone_set('America/Recife');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataAtual = Carbon::now();
        $dataAtual = (Carbon::parse($dataAtual)->format('yy-m-d'));
        
        $statusProjetos = StatusProjeto::all();
        $clientes = Cliente::all();
        return view('projetos.projetos', compact('projetos', 'dataAtual', 'statusProjetos', 'clientes'));
    }

    public function filtrar($projetos){

        $projetosFiltrados = $projetos;

        
        if(request()->has('clienteProjeto') && !empty(request('clienteProjeto'))){
            
            $projetosFiltrados = $projetosFiltrados->where('cliente_id', request('clienteProjeto'));
          
        }

        if(request()->has('statusProjeto') && !empty(request('statusProjeto'))){
            $projetosFiltrados = $projetosFiltrados->where('status_id', request('statusProjeto'));
        }

        if(request()->has('atraso') && !empty(request('atraso'))){
            $projetosFiltrados = $projetosFiltrados->where('emAtraso', 1)->where('finalizado', 0);
        }
        return $projetosFiltrados;

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
        $validatedData = $request->validate([
            'nomeProjeto' => 'required|max:255',
            'descProjeto' => 'required|max:255',
            'cliente' => 'required|exists:clientes,id',
            'dataPrevista' => 'required'
        ]);

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
        if(Auth::user()->admin == 0){
            abort(404);
        }
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
        
        if(Auth::user()->admin == 0){
            abort(404);
        }

        $validatedData = $request->validate([
            'nomeProjeto' => 'required|max:255',
            'descProjeto' => 'required|max:255',
            'cliente' => 'required|exists:clientes,id',
            'dataPrevista' => 'required',
            'status' => 'required|exists:status_projetos,id' 
        ]);

        $projeto = Projeto::find($id);
            if(isset($projeto)){
            date_default_timezone_set('America/Recife');
            setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
            setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
            $dataHora = Carbon::now();

            if($request->status == 4){
                $projeto->finalizado = 1;
                $projeto->data_finalizacao = Carbon::parse($dataHora)->format('y-m-d H:i:s');
            }
            else{
                $projeto->finalizado = 0;
                $projeto->data_finalizacao =null;
            }
            $projeto->nome = $request->input('nomeProjeto');
            $projeto->descricao = $request->input('descProjeto');
            $projeto->cliente_id = $request->input('cliente');
            $projeto->tempo_gasto = $projeto->tempo_gasto;
            $projeto->status_id = $request->input('status');
            $projeto->data_prevista = $request->input('dataPrevista');
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
        if(Auth::user()->admin == 0){
            abort(404);
        }
        $projeto = Projeto::find($id);
        $this->deletaDependentes($id);
        if(isset($projeto)){
            $projeto->delete();
        }
        return redirect("/projetos");
    }

    public function deletaDependentes($idProjeto){

        $tarefasProjeto = Tarefa::where('projeto_id', $idProjeto)->get();
        foreach($tarefasProjeto as $tarefa){
            $tarefaUsuario = TarefaUsuario::where('tarefa_id', $tarefa->id)->get();
            foreach($tarefaUsuario as $tarUsu){
                $tarUsu->delete();
            }
            $tarefa->delete();
        }

        $projetoUsuario = ProjetoUsuario::where('projeto_id', $idProjeto)->get();
        foreach($projetoUsuario as $projUsu){
            $projUsu->delete();
        }
    }
    public function downloadRelatorio(Request $request){
     
        //$dados = (Collect(json_decode(rawurldecode($request->clientes))));
        $dados = (Collect(json_decode($request->projetos)));
   
        
        $html = '<h1> Relatório - Projetos </h1>';
        
   
       foreach($dados as $dado){
                $html = $html. '<table cellspacing="0" cellpadding="1" border="1">   
                <tr style="background-color:#D9A5F3;color:#FFFFFF;">
                <td>ID</td>
                <td colspan="2">NOME</td>
                <td colspan="2">CLIENTE</td>
                <td colspan="2">DESCRICAO</td>
                <td colspan="2">DATA PREVISTA</td>
                </tr>';
                $html = $html.'<tr>';
                $html = $html.'<td> '.$dado->id . '</td> ';
                $html = $html.'<td colspan="2"> '.$dado->nome . '</td> ';
                $html = $html.'<td colspan="2"> '.$dado->cliente->nome . '</td> ';
                $html = $html.'<td colspan="2"> '.$dado->descricao . '</td> ';
                $html = $html.'<td colspan="2"> '.$dado->data_prevista . '</td> ';

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

                
                $usuarios = ProjetoUsuario::where('projeto_id', $dado->id)->get();

                $html = $html.'<h2> Usuários </h2>';

                
                $html = $html. '<table cellspacing="0" cellpadding="1" border="1">   
                <tr style="background-color:#D9A5F3;color:#FFFFFF;">
                <td colspan="2">USUARIO</td>
                <td colspan="2">TEMPO TOTAL GASTO</td>
                </tr>';
                if(count($usuarios) > 0){
                    foreach($usuarios as $usuario){
                       
                        $user = User::findOrFail($usuario->user_id);
                        $html = $html.'<tr>';
                        $html = $html.'<td colspan="2"> '.$user->name . '</td> ';
                        $html = $html.'<td colspan="2"> '.$usuario->tempo_total . '</td> ';

                        $html = $html.'</tr>';
    

                    }
                }

                $html = $html. '
                </table> <br> <hr>';    

                $tarefas = Tarefa::where('projeto_id', $dado->id)->get();

                $html = $html.'<h2> Tarefas </h2>';

                
                $html = $html. '<table cellspacing="0" cellpadding="1" border="1">   
                <tr style="background-color:#D9A5F3;color:#FFFFFF;">
                <td colspan="2">ID</td>
                <td colspan="2">NOME</td>
                <td colspan="2">FINALIZADA?</td>
                <td colspan="2">DATA FINALIZACAO</td>
                </tr>';
                if(count($tarefas) > 0){
                    foreach($tarefas as $tarefa){
                        $html = $html.'<tr rowspan="1">';
                        $html = $html.'<td colspan="2"> '.$tarefa->id . '</td> ';
                        $html = $html.'<td colspan="2"> '.$tarefa->nome . '</td> ';
                        if(isset($tarefa->finalizado) && $tarefa->finalizado == 1){
                            $html = $html.'<td colspan="2"> '.'SIM' . '</td> ';
                            $html = $html.'<td colspan="2"> '.$tarefa->data_finalizacao . '</td> ';
                        }
                        else{
                            $html = $html.'<td colspan="2"> '.'NAO' . '</td> ';
                            $html = $html.'<td colspan="2"> '.'-' . '</td> ';
                        }

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
