<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarefaUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefa_usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tarefa_id')->unsigned();
            $table->foreign('tarefa_id')->references('id')->on('tarefas')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->time('tempo_gasto');
            $table->dateTime('ultimo_start');
            $table->dateTime('ultimo_stop');
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
        Schema::dropIfExists('tarefa_usuarios');
    }
}
