<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tarefa;
use Illuminate\Support\Carbon;
class Historico extends Model
{
    protected $appends = ['nomeTarefa', 'horas', 'horaInicio', 'horaFim'];
    protected $dates = ['dia'];
    public function getNomeTarefaAttribute(): string
    {
       $tarefa = Tarefa::where('id', $this->tarefa_id)->withTrashed()->get()->first();
       
       if ($tarefa) {
           return $tarefa->nome;
       }
       return '';
    }

    public function getHorasAttribute(){
        $fim = Carbon::parse($this->stop);
        $inicio = Carbon::parse($this->start);
        $total = $inicio->diffInHours($fim) . ':' . $inicio->diff($fim)->format('%I:%S');
        return $total;
    }

    public function getHoraInicioAttribute(){
        $dataInicio  = Carbon::parse($this->start);
        $horaInicio = Carbon::parse($dataInicio)->format('H:i:s');
        return $horaInicio;
    }

    public function getHoraFimAttribute(){
        $dataFim  = Carbon::parse($this->stop);
        $horaFim = Carbon::parse($dataFim)->format('H:i:s');
        return $horaFim;
    }

    public function tarefa(){
        return $this->belongsTo('App\Tarefa')->withTrashed();
    }



}
