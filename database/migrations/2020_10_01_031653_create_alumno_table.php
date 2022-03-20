<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumno', function (Blueprint $table) {
            $table->char('no_de_control', 10)->primary();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->smallInteger('semestre');
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id')->on('usuario');
            $table->unsignedBigInteger('id_carrera');
            $table->foreign('id_carrera')->references('id')->on('carrera');
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
        Schema::dropIfExists('alumno');
    }
}
