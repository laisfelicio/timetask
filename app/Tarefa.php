<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
class Tarefa extends Model
{
    //
    protected $appends = ['emAtraso'];
    use SoftDeletes;

    public function status(){
        return $this->belongsTo('App\StatusTarefa');
     }

     public function cliente(){
        return $this->belongsTo('App\Cliente');
     }

     public function users(){
        return $this->belongsToMany('App\User', 'tarefa_usuarios', 'tarefa_id', 'user_id')->whereNull('tarefa_usuarios.deleted_at');
    }

    public function projeto(){
        return $this->belongsTo('App\Projeto');
    }


    public function comentarios(){
        return $this->hasMany('App\Comentario');
    }

    public function getEmAtrasoAttribute(){
        $dataAtual = Carbon::now();
        $dataAtual = Carbon::parse($dataAtual)->format('yy-m-d');
        if($this->data_prevista < $dataAtual){
           return 1;
        }
        else{
           return 0;
        }
    }

    public function historicos(){
        return $this->hasMany('App\Historico');
    }


     
}
