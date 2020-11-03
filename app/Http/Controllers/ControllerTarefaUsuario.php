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
        
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataAtual = Carbon::now();
        $dataAtual = (Carbon::parse($dataAtual)->format('yy-m-d'));
        $usuarioId = Auth::user()->id;
        $tarefas = Auth::user()->tarefas;
        
        return view('tarefas.minhastarefas', compact('tarefas', 'dataAtual'));

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
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataHora = Carbon::now();
        
        $tarefaUsu->ultimo_start = Carbon::parse($dataHora)->format('y-m-d H:i:s');
        $tarefaUsu->save();

        return redirect("/gerenciarTarefa/".$tarefaId);
    }

    public function stopTimer($tarefaId){
        $usuarioId = Auth::user()->id;
        $tarefaUsu = TarefaUsuario::where('tarefa_id', $tarefaId)->where('user_id', $usuarioId)->first();
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataHora = Carbon::now();
        
      
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
        date_default_timezone_set('America/Sao_Paulo');
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
    
}
