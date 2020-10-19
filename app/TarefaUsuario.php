<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TarefaUsuario extends Model
{
    //
    use SoftDeletes;
    protected $appends = ['tarefa', 'nomeUsuario', 'emailUsuario', 'idUsuario', 
    'nomeTarefa', 'nomeProjeto', 'descricaoTarefa', 'tempoPrevistoTarefa', 'statusTarefa', 'idProjeto', 'dataPrevista'];

    public function getTarefaAttribute(): string
     {
        $tarefa = Tarefa::find($this->tarefa_id);

        if ($tarefa) {
            return $tarefa->nome;
        }
        return '';
     }

     public function getDataPrevistaAttribute(): string
     {
        $tarefa = Tarefa::find($this->tarefa_id);

        if ($tarefa) {
            return $tarefa->data_prevista;
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

     public function getNomeTarefaAttribute(): string
     {
        $tarefa = Tarefa::find($this->tarefa_id);

        if ($tarefa) {
            return $tarefa->nome;
        }
        return '';
     }

     public function getNomeProjetoAttribute(): string
     {
        $tarefa = Tarefa::find($this->tarefa_id);
        if($tarefa){
            $projeto = Projeto::find($tarefa->projeto_id);

            
            if ($projeto) {
                return $projeto->nome;
            }
            return '';
        }
        else{
            return '';
        }

     }

     public function getIdProjetoAttribute(): string
     {
        $tarefa = Tarefa::find($this->tarefa_id);
        if($tarefa){
            $projeto = Projeto::find($tarefa->projeto_id);

            if ($projeto) {
                return $projeto->id;
            }
            return '';
        }
        else{
            return '';
        }
     }

     public function getDescricaoTarefaAttribute(): string
     {
        $tarefa = Tarefa::find($this->tarefa_id);

        if ($tarefa) {
            return $tarefa->descricao;
        }
        return '';
     }

     public function getTempoPrevistoTarefaAttribute(): string
     {
        $tarefa = Tarefa::find($this->tarefa_id);

        if ($tarefa) {
            return $tarefa->tempo_previsto;
        }
        return '';
     }

     public function getStatusTarefaAttribute(): string
     {
        $tarefa = Tarefa::find($this->tarefa_id);
        if($tarefa){
            $status = StatusTarefa::find($tarefa->status_id);
            if ($tarefa) {
                return $status->nome;
            }
            return '';
        }
        else{
            return '';
        }
     }

     


}
