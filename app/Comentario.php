<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    //

    protected $appends = ['nomeUsuario', 'emailUsuario'];
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
}
