<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProjetoUsuario extends Model
{
    //
    use SoftDeletes;
    protected $appends = ['projeto', 'nomeUsuario', 'emailUsuario', 'idUsuario'];

    public function getProjetoAttribute(): string
     {
        $projeto = Projeto::find($this->projeto_id);

        if ($projeto) {
            return $projeto->nome;
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
