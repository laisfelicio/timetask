<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClientesExport;
use PDF;
class ControllerCliente extends Controller
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
        $clientes = Cliente::all();
        return view('clientes.clientes', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->admin == 0){
            abort(404);
        }
        return view('clientes.novoCliente');
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
        if(Auth::user()->admin == 0){
            abort(404);
        }

        $regras = [
            'nomeCliente' => 'required|max:255'
        ];


        $mensagens = [
            'nomeCliente.required' => 'Digite o nome do cliente',
            'nomeCliente.max' => 'Máximo de caracteres: 255'
        ];

        $validateData = $request->validate($regras, $mensagens);

        $cliente = new Cliente();
        $cliente->nome = $request->input('nomeCliente');
        $cliente->save();
        return redirect('/clientes');
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
        if(Auth::user()->admin == 0){
            abort(404);
        }
        $cli = Cliente::find($id);
        if(isset($cli)){
            return view('clientes.editarCliente', compact('cli'));
        }
        return redirect('/clientes');
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
        if(Auth::user()->admin == 0){
            abort(404);
        }

        $regras = [
            'nomeCliente' => 'required|max:255'
        ];


        $mensagens = [
            'nomeCliente.required' => 'Digite o nome do cliente',
            'nomeCliente.max' => 'Máximo de caracteres: 255'
        ];

        $validateData = $request->validate($regras, $mensagens);

        $cliente = Cliente::find($id);
        if(isset($cliente)){
            $cliente->nome = $request->input('nomeCliente');
            $cliente->save();
        }
        return redirect('/clientes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->admin == 0){
            abort(404);
        }
        
        $cliente = Cliente::find($id);
        if(isset($cliente)){
            $cliente->delete();
        }
        return redirect("/clientes");
       
    }

    public function downloadRelatorio(Request $request){
     
     //$dados = (Collect(json_decode(rawurldecode($request->clientes))));
     $dados = (Collect(json_decode($request->clientes)));
     
   

     $html = '<h1> Relatório - Clientes </h1>';
     $html = $html. '<table cellspacing="0" cellpadding="1" border="1">   
         <tr style="background-color:#D9A5F3;color:#FFFFFF;">
             <td>ID</td>
             <td>NOME</td>
         </tr>';

    foreach($dados as $dado){
            $html = $html.'<tr>';
            $html = $html.'<td> '.$dado->id . '</td> ';
            $html = $html.'<td> '.$dado->nome . '</td> ';
            $html = $html.'</tr>';
    }   

    $html = $html. '
        </table>';     
    
        
       
    PDF::SetTitle('Hello World');
    PDF::AddPage();
    PDF::writeHTML($html, true, false, true, false, '');

    PDF::Output('hello_world.pdf');
        
    PDF::SetTitle('Hello World');
    PDF::AddPage();
    PDF::writeHTML($html, true, false, true, false, '');
    PDF::Output('hello_world.pdf');

     }
}
