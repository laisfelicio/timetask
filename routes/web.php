<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcomeNovo');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/relatorio', 'ControllerRelatorio@index');

Route::get('/clientes', 'ControllerCliente@index');
Route::get('/clientes/novo', 'ControllerCliente@create');
Route::post('/clientes', 'ControllerCliente@store');
Route::get('/clientes/apagar/{id}', 'ControllerCliente@destroy');
Route::get('/clientes/editar/{id}', 'ControllerCliente@edit');
Route::post('/clientes/{id}', 'ControllerCliente@update');
Route::post('/clientes/files/download', 'ControllerCliente@downloadRelatorio')->name('clientes.download');


Route::get('/projetos', 'ControllerProjeto@index');
Route::get('/projetos/novo', 'ControllerProjeto@create');
Route::post('/projetos', 'ControllerProjeto@store');
Route::get('/projetos/apagar/{id}', 'ControllerProjeto@destroy');
Route::get('/projetos/editar/{id}', 'ControllerProjeto@edit');
Route::post('/projetos/{id}', 'ControllerProjeto@update');
Route::post('/projetos/files/download', 'ControllerProjeto@downloadRelatorio')->name('projetos.download');


Route::get('/tarefas', 'ControllerTarefa@index');
Route::get('/tarefas/novo', 'ControllerTarefa@create');
Route::post('/tarefas', 'ControllerTarefa@store');
Route::get('/tarefas/apagar/{id}', 'ControllerTarefa@destroy');
Route::get('/tarefas/editar/{id}', 'ControllerTarefa@edit');
Route::post('/tarefas/{id}', 'ControllerTarefa@update');
Route::get('/tarefas/alocar/{id}', 'ControllerTarefa@alocar');
Route::post('/tarefas/salvaalocacao/{id}', 'ControllerTarefa@salvaAlocacao');
Route::get('/tarefas/info/{id}', 'ControllerTarefa@info');
Route::post('/tarefas/files/download', 'ControllerTarefa@downloadRelatorio')->name('tarefas.download');

Route::get('/statustarefa', 'ControllerStatusTarefa@index');
Route::get('/statustarefa/novo', 'ControllerStatusTarefa@create');
Route::post('/statustarefa', 'ControllerStatusTarefa@store');
Route::get('/statustarefa/apagar/{id}', 'ControllerStatusTarefa@destroy');
Route::get('/statustarefa/editar/{id}', 'ControllerStatusTarefa@edit');
Route::post('/statustarefa/{id}', 'ControllerStatusTarefa@update');

Route::get('/projetousuario/alocar/{id}', 'ControllerProjetoUsuario@index');
Route::get('/projetousuario/info/{id}', 'ControllerProjetoUsuario@show');
Route::post('/projetousuario', 'ControllerProjetoUsuario@store');
Route::get('/projetousuario/apagar/{idProjeto}/{idUsuario}', 'ControllerProjetoUsuario@destroy');
Route::get('/projetousuario/meusprojetos', 'ControllerProjetoUsuario@getProjetoUsuario');
Route::post('/projetousuario/files/download', 'ControllerProjetoUsuario@downloadRelatorio')->name('meusprojetos.download');

Route::get('/tarefausuario/{idProjeto}/{idTarefa}', 'ControllerTarefaUsuario@index');
Route::post('/tarefausuario', 'ControllerTarefaUsuario@store');
Route::get('/tarefausuario/info/{idProjeto}/{idTarefa}', 'ControllerTarefaUsuario@show');
Route::get('/tarefausuario/apagar/{alocacao}/{id}', 'ControllerTarefaUsuario@destroy');
Route::get('/tarefausuario/minhastarefas', 'ControllerTarefaUsuario@getTarefasUsuario');
Route::get('/gerenciarTarefa/{id}', 'ControllerTarefaUsuario@detalhesTarefa');
Route::get('/comecatimer/{id}', 'ControllerTarefaUsuario@startTimer');
Route::get('/stoptimer/{id}', 'ControllerTarefaUsuario@stopTimer');
Route::post('/tarefausuario/files/download', 'ControllerTarefaUsuario@downloadRelatorio')->name('minhastarefas.download');


Route::get('/kanban', 'ControllerKanban@index');
Route::post('/comentarios', 'ControllerComentario@store');
Route::post('/gerenciarTarefa', 'ControllerTarefaUsuario@gerenciar');
Route::get('/usuarios/registrar', 'ControllerUsuario@create');
Route::post('/usuarios', 'ControllerUsuario@store');
Route::get('/usuarios', 'ControllerUsuario@index');
Route::post('/usuarios/{id}', 'ControllerUsuario@update');
Route::get('/usuarios/editar/{id}', 'ControllerUsuario@edit');
Route::get('/usuarios/apagar/{id}', 'ControllerUsuario@destroy');
Route::post('/usuarios/files/download', 'ControllerUsuario@downloadRelatorio')->name('usuarios.download');

Route::get('/timesheet', 'ControllerHistorico@index');
Route::get('/editarTimeSheet/{id}', 'ControllerHistorico@edit');
Route::post('/timesheet/{id}', 'ControllerHistorico@update');
Route::get('/timesheet/novo', 'ControllerHistorico@create');
Route::post('/timesheet', 'ControllerHistorico@store');
Route::post('/timesheet/files/download', 'ControllerHistorico@downloadRelatorio')->name('timesheet.download');

