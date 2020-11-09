<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
class Projeto extends Model
{
    //
    protected $appends = ['emAtraso'];
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
}
