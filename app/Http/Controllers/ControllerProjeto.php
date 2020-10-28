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
        
        date_default_timezone_set('America/Sao_Paulo');
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
        $columns = ['clienteProjeto', 'statusProjeto', 'excluidos', 'emAtraso'];

        
        if(request()->has('clienteProjeto') && !empty(request('clienteProjeto'))){
            
            $projetosFiltrados = $projetosFiltrados->where('cliente_id', request('clienteProjeto'));
          
        }

        if(request()->has('statusProjeto') && !empty(request('statusProjeto'))){
            $projetosFiltrados = $projetosFiltrados->where('status_id', request('statusProjeto'));
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
            date_default_timezone_set('America/Sao_Paulo');
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
        if(isset($projeto)){
            $projeto->delete();
        }
        return redirect("/projetos");
    }

    public function downloadRelatorio(Request $request){
     
        //$dados = (Collect(json_decode(rawurldecode($request->clientes))));
        $dados = (Collect(json_decode($request->projetos)));
   
        $html = '<h1> Relatório - Projetos </h1>';
        $html = $html. '<table cellspacing="0" cellpadding="1" border="1">   
            <tr style="background-color:#D9A5F3;color:#FFFFFF;">
                <td>ID</td>
                <td>NOME PROJETO</td>
                <td>DESCRICAO</td>
                <td>CLIENTE</td>
                <td>TEMPO GASTO</td>
                <td>DATA PREVISTA</td>
            </tr>';
   
       foreach($dados as $dado){
               $html = $html.'<tr>';
               $html = $html.'<td> '.$dado->id . '</td> ';
               $html = $html.'<td> '.$dado->nome . '</td> ';
               $html = $html.'<td> '.$dado->descricao . '</td> ';
               $html = $html.'<td> '.$dado->cliente . '</td> ';
               $html = $html.'<td> '.$dado->tempo_gasto . '</td> ';
               $html = $html.'<td> '.$dado->data_prevista . '</td> ';
               $html = $html.'</tr>';
       }   
   
       $html = $html. '
           </table>';     

       PDF::SetTitle('Relatório - Projetos');
       PDF::AddPage();
       PDF::writeHTML($html, true, false, true, false, '');
   
       PDF::Output('relatorio_projeto.pdf');
           
   
    }
   
   
}
