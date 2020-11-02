<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Projeto extends Model
{
    //
    use SoftDeletes;
    protected $appends = ['cliente', 'status'];

    public function getClienteAttribute(): string
     {
        $cliente = Cliente::find($this->cliente_id);

        if ($cliente) {
            return $cliente->nome;
        }
        return '';
     }

     public function getStatusAttribute(): string
     {
        $status = StatusProjeto::find($this->status_id);

        if ($status) {
            return $status->nome;
        }
        return '';
     }

     public function users(){
         return $this->belongsToMany('App\User', 'projeto_usuarios', 'projeto_id', 'user_id');
     }
}
