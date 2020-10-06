<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarefa extends Model
{
    //
    use SoftDeletes;
    protected $appends = ['projeto', 'status'];

    public function getProjetoAttribute(): string
     {
        $projeto = Projeto::find($this->projeto_id);

        if ($projeto) {
            return $projeto->nome;
        }
        return '';
     }

     public function getStatusAttribute(): string
     {
        $status = StatusTarefa::find($this->status_id);

        if ($status) {
            return $status->nome;
        }
        return '';
     }
}
