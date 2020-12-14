<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
class Projeto extends Model
{
    //
    protected $appends = ['emAtraso'];
    protected $dates = ['data_prevista', 'data_finalizacao'];
    use SoftDeletes;

    
     public function users(){
         return $this->belongsToMany('App\User', 'projeto_usuarios', 'projeto_id', 'user_id')->whereNull('projeto_usuarios.deleted_at');
     }

     public function usersTrashed(){
      return $this->belongsToMany('App\User', 'projeto_usuarios', 'projeto_id', 'user_id')->withTrashed();
  }

     public function cliente(){
        return $this->belongsTo('App\Cliente')->withTrashed();
     }

     public function clienteTrashed(){
        return $this->belongsTo('App\Cliente')->withTrashed();
     }

     public function status(){
        return $this->belongsTo('App\StatusProjeto');
     }

     public function tarefas(){
        return $this->hasMany('App\Tarefa');
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

     public function tarefasTrashed(){
      return $this->hasMany('App\Tarefa')->withTrashed();
  }
}
