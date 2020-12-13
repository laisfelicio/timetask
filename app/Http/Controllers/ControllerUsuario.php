<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\TarefaUsuario;
use App\ProjetoUsuario;
use PDF;

class ControllerUsuario extends Controller
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
        $usuarios = User::all();
        return view('usuarios.usuarios', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(Auth::user()->admin == 0){
            abort(404);
        }
        return view('usuarios.registrar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     
    public function store(Request $request)
    {
        if(Auth::user()->admin == 0){
            abort(404);
        }

        $regras = [
            'nomeUsuario' => 'required|max:255',
            'emailUsuario' => 'required|email|max:255|unique:users,email',
            'senhaUsuario' => 'required|min:8|max:255'
        ];

        $mensagens = [
            'nomeUsuario.required' => 'Digite o nome do usuário',
            'nomeUsuario.max' => 'Tamanho máximo: 255',
            'emailUsuario.required' => 'Digite o e-mail',
            'emailUsuario.email' => 'Campo deve ser do tipo e-mail',
            'emailUsuario.max' => 'Tamanho máximo: 255',
            'senhaUsuario.required' => 'Digite a senha',
            'senhaUsuario.min' => 'Senha deve ter no mínimo 8 caracteres',
            'senhaUsuario.max' => 'Senha deve ter no máximo 255 caracteres',
            'emailUsuario.unique' => 'E-mail já cadastrado'
        ];

        $validateData = $request->validate($regras, $mensagens);
        $user = new User();
        $user->name = $request->input('nomeUsuario');
        $user->email = $request->input('emailUsuario');
        $user->password = Hash::make($request->input('senhaUsuario'));
        if($request->input('admin') == "sim"){
            $user->admin = 1;
        }
        else{
            $user->admin = 0;
        }
        $user->save();
        return redirect('/usuarios');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $usuario = User::where('id', Auth::user()->id)->first();
        return view('usuarios.perfil', compact('usuario'));

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

        $usuario = User::find($id);
        if(isset($usuario)){
            return view('usuarios.editarusuario', compact('usuario'));
        }
        return redirect('/usuarios');
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
            'nomeUsuario' => 'required|max:255',
            'emailUsuario' => 'required|email|max:255|unique:users,email,'.Auth::user()->id.'',
            'senhaUsuario' => 'required|min:8|max:255'
        ];


        $mensagens = [
            'nomeUsuario.required' => 'Digite o nome do usuário',
            'nomeUsuario.max' => 'Tamanho máximo: 255',
            'emailUsuario.required' => 'Digite o e-mail',
            'emailUsuario.email' => 'Campo deve ser do tipo e-mail',
            'emailUsuario.max' => 'Tamanho máximo: 255',
            'senhaUsuario.required' => 'Digite a senha',
            'senhaUsuario.min' => 'Senha deve ter no mínimo 8 caracteres',
            'senhaUsuario.max' => 'Senha deve ter no máximo 255 caracteres',
            'emailUsuario.unique' => 'E-mail já cadastrado'
        ];

        $validateData = $request->validate($regras, $mensagens);

        $usuario = User::find($id);
        if(isset($usuario)){
            $usuario->name = $request->input('nomeUsuario');
            $usuario->email = $request->input('emailUsuario');
            $usuario->password = Hash::make($request->input('senhaUsuario'));
            $usuario->save();
        }

 
        return redirect('/usuarios');
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
        $usuario = User::find($id);
        if(isset($usuario)){
            $this->deletaDependentes($id);
            $usuario->delete();
        }
        return redirect("/usuarios");
    }

    public function deletaDependentes($idUsuario){

        $tarefasUsuario = TarefaUsuario::where('user_id', $idUsuario)->get();
        foreach($tarefasUsuario as $tarefa){
                $tarefa->delete();
        }

        $projetoUsuario = ProjetoUsuario::where('user_id', $idUsuario)->get();
        foreach($projetoUsuario as $projUsu){
            $projUsu->delete();
        }
    }

    public function downloadRelatorio(Request $request){
     
        //$dados = (Collect(json_decode(rawurldecode($request->clientes))));
        $dados = (Collect(json_decode($request->usuarios)));
   
        
        $html = '<h1> Relatório - Usuários </h1>';
        $html = $html. '<table cellspacing="0" cellpadding="1" border="1">   
            <tr style="background-color:#D9A5F3;color:#FFFFFF;">
                <td>ID</td>
                <td>NOME</td>
                <td>EMAIL</td>
                <td>ADMIN?</td>
            </tr>';
   
       foreach($dados as $dado){
               $html = $html.'<tr>';
               $html = $html.'<td> '.$dado->id . '</td> ';
               $html = $html.'<td> '.$dado->name . '</td> ';
               $html = $html.'<td> '.$dado->email . '</td> ';
               if($dado->admin == 1){
                $html = $html.'<td> '.'SIM'. '</td> ';
               }
               else{
                $html = $html.'<td> '.'NAO'. '</td> ';
               }
               $html = $html.'</tr>';
       }   
   
       $html = $html. '
           </table>';     

       PDF::SetTitle('Relatório - Usuários');
       PDF::AddPage();
       PDF::writeHTML($html, true, false, true, false, '');
   
       PDF::Output('relatorio_usuario.pdf');
           
   
    }
}
