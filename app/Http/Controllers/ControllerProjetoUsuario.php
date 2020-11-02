<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProjetoUsuario;
use App\Projeto;
use App\Tarefa;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use App\StatusProjeto;
use App\Cliente;

class ControllerProjetoUsuario extends Controller
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
    
    public function index($id)
    {
        //
      
        $projeto = Projeto::find($id);
        $usuarios = User::all();
        return view('projetos.alocarUsuario', compact('projeto', 'usuarios'));
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
            'idProjeto' => ['required'],
            'usuario' => ['required', 'unique:projeto_usuarios,user_id,NULL,id,projeto_id,' . $request->input('idProjeto')],
        ]);


        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataAtual = Carbon::now();
        $dataAtual = (Carbon::parse($dataAtual)->format('yy-m-d'));
        $projUsu = new ProjetoUsuario();
        $projUsu->projeto_id = $request->input('idProjeto');
        $projUsu->user_id = $request->input('usuario');
        $projUsu->tempo_total = "00:00:00";
        $projUsu->save();
        return redirect('/projetousuario/info/'.$request->input('idProjeto'));
    }

    /**
     * Dis6play the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataAtual = Carbon::now();
        $dataAtual = (Carbon::parse($dataAtual)->format('yy-m-d'));
        $alocados= ProjetoUsuario::where('projeto_id', $id)->get();
        $projeto = Projeto::find($id);
        $tarefas = Tarefa::where('projeto_id', $id)->get();
        return view('projetos.info', compact('alocados', 'projeto', 'tarefas', 'dataAtual'));
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
        
        $projUsu = ProjetoUsuario::find($id);
        $projetoId = $projUsu->projeto_id;
        if(isset($projUsu)){
            $projUsu->delete();
        }
        return redirect("/projetousuario/info/".$projetoId);
        
    }

    public function filtrar($projetos){

        dd($projetos);
        $projetosFiltrados = $projetos;

        
        if(request()->has('clienteProjeto') && !empty(request('clienteProjeto'))){
            
            $projetosFiltrados = $projetosFiltrados->where('clienteProjeto', request('clienteProjeto'));
          
        }

        if(request()->has('statusProjeto') && !empty(request('statusProjeto'))){
            $projetosFiltrados = $projetosFiltrados->where('statusProjeto', request('statusProjeto'));
        }

        return $projetosFiltrados;

    }

    public function getProjetoUsuario(){
        
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataAtual = Carbon::now();
        $dataAtual = (Carbon::parse($dataAtual)->format('yy-m-d'));
        $statusProjetos = StatusProjeto::all();
        $clientes = Cliente::all();
        $usuarioId = Auth::user()->id;
        $projetos = Auth::user()->projetos;
        
        return view('projetos.meusprojetos', compact('projetos', 'statusProjetos', 'dataAtual', 'clientes'));

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
                $html = $html.'<td colspan="2"> '.$dado->nomeProjeto . '</td> ';
                $html = $html.'<td colspan="2"> '.$dado->clienteProjeto . '</td> ';
                $html = $html.'<td colspan="2"> '.$dado->descricaoProjeto . '</td> ';
                $html = $html.'<td colspan="2"> '.$dado->dataPrevistaProjeto . '</td> ';

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
                $html = $html.'<td colspan="2"> '.$dado->statusProjeto . '</td> ';
                if(isset($dado->projetoFinalizado) && $dado->projetoFinalizado == 1){
                    $html = $html.'<td colspan="2"> '.'SIM' . '</td> ';
                    $html = $html.'<td colspan="2"> '.$dado->dataFinalizacaoProjeto. '</td> ';
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
                        $html = $html.'<tr>';
                        $html = $html.'<td colspan="2"> '.$usuario->nomeUsuario . '</td> ';
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
