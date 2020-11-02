<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use date;
class ProjetoUsuario extends Model
{
    //
    use SoftDeletes;
    protected $appends = ['nomeProjeto', 'nomeUsuario', 'emailUsuario', 'idUsuario', 
                           'clienteProjeto', 'statusProjeto', 'descricaoProjeto', 
                           'dataPrevistaProjeto', 'dataFinalizacaoProjeto', 'projetoFinalizado'];

    public function getNomeProjetoAttribute(): string
     {
        $projeto = Projeto::find($this->projeto_id);

        if ($projeto) {
            return $projeto->nome;
        }
        return '';
     }

     public function getDescricaoProjetoAttribute(): string
     {
        $projeto = Projeto::find($this->projeto_id);

        if ($projeto) {
            return $projeto->descricao;
        }
        return '';
     }

     public function getProjetoFinalizadoAttribute(): string
     {
        $projeto = Projeto::find($this->projeto_id);

        if ($projeto) {
            return $projeto->finalizado;
        }
        return '';
     }


     public function getDataPrevistaProjetoAttribute()
     {
        $projeto = Projeto::find($this->projeto_id);

        if ($projeto) {
            return $projeto->data_prevista;
        }
        return '';
     }

     public function getDataFinalizacaoProjetoAttribute()
     {
        $projeto = Projeto::find($this->projeto_id);

        if ($projeto) {
            return $projeto->data_finalizacao;
        }
        return '';
     }

     public function getClienteProjetoAttribute(): string
     {
        $projeto = Projeto::find($this->projeto_id);

        if ($projeto) {
            $cliente = Cliente::find($projeto->cliente_id);
            if($cliente){
                return $cliente->nome;
            }
        }
        return '';
     }

     public function getStatusProjetoAttribute(): string
     {
        $projeto = Projeto::find($this->projeto_id);

        if ($projeto) {
            $status = StatusProjeto::find($projeto->status_id);
            if($status){
                return $status->nome;
            }
        }
        return '';
     }


     public function getNomeUsuarioAttribute(): string
     {
        $usuario = User::find($this->user_id);

        if ($usuario) {
            return $usuario->name;
        }
        return '';
     }

     public function getEmailUsuarioAttribute(): string
     {
        $usuario = User::find($this->user_id);

        if ($usuario) {
            return $usuario->email;
        }
        return '';
     }

     public function getIdUsuarioAttribute(): string
     {
        $usuario = User::find($this->user_id);

        if ($usuario) {
            return $usuario->id;
        }
        return '';
     }
}
