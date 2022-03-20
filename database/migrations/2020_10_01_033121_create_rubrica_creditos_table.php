<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRubricaCreditosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rubrica_evaluacion_credito', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('criterio_1')->nullable();
            $table->smallInteger('criterio_2')->nullable();
            $table->smallInteger('criterio_3')->nullable();
            $table->smallInteger('criterio_4')->nullable();
            $table->smallInteger('criterio_5')->nullable();
            $table->smallInteger('criterio_6')->nullable();
            $table->smallInteger('criterio_7')->nullable();
            $table->text('observaciones')->nullable();
            $table->float('valor', 8, 2)->nullable();
            $table->unsignedBigInteger('id_responsable');
            $table->foreign('id_responsable')->references('id')->on('responsable_actividad_complementaria');
            $table->boolean('estatus')->default(false);
            $table->timestamps();
        });
    }

    /* 
        Estatus
        True -> Calificada
        False -> No calificada
    */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rubrica_evaluacion_credito');
    }
}
