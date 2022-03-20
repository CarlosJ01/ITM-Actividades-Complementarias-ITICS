<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpedienteCreditosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expediente_creditos', function (Blueprint $table) {
            $table->char('no_de_control', 10)->primary();
            $table->foreign('no_de_control')->references('no_de_control')->on('alumno');
            $table->date('fecha_apertura');
            $table->date('fecha_cierre')->nullable();
            $table->smallInteger('creditos')->default(0);
            $table->float('promedio_rubricas', 8, 2)->default(0);
            $table->text('url_constancia_liberacion')->nullable();
            $table->unsignedBigInteger('id_periodo');
            $table->foreign('id_periodo')->references('id')->on('periodo');
            $table->boolean('estatus')->default(true);
            $table->timestamps();
            /* Estatus */
            /* 
                true -> Abierto
                false -> Cerrado
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expediente_creditos');
    }
}
