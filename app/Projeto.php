<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Projeto extends Model
{
    //
    use SoftDeletes;

    
     public function users(){
         return $this->belongsToMany('App\User', 'projeto_usuarios', 'projeto_id', 'user_id');
     }

     public function cliente(){
        return $this->belongsTo('App\Cliente');
     }

     public function status(){
        return $this->belongsTo('App\StatusProjeto');
     }

     public function tarefas(){
        return $this->hasMany('App\Tarefa');
     }
}
