<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarefa extends Model
{
    //
    use SoftDeletes;

    public function status(){
        return $this->belongsTo('App\StatusTarefa');
     }

     public function cliente(){
        return $this->belongsTo('App\Cliente');
     }

     public function users(){
        return $this->belongsToMany('App\User', 'tarefa_usuarios', 'tarefa_id', 'user_id');
    }

    public function projeto(){
        return $this->belongsTo('App\Projeto');
    }

    public function comentarios(){
        return $this->hasMany('App\Comentario');
    }




     
}
