<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarefasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('projeto_id')->unsigned();
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
            $table->string('descricao');
            $table->time('tempo_previsto');
            $table->date('data_prevista');
            $table->dateTime('data_finalizacao')->nullable();
            $table->time('tempo_gasto')->nullale();
            $table->integer('finalizado')->default(0);
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('status_tarefas');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarefas');
    }
}
