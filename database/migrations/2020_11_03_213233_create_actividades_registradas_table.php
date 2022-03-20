<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadesRegistradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades_registradas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('no_de_control', 10);
            $table->foreign('no_de_control')->references('no_de_control')->on('expediente_creditos');
            $table->unsignedBigInteger('id_credito_complementario');
            $table->foreign('id_credito_complementario')->references('id')->on('credito_complementario');
            $table->string('fecha_inicio');
            $table->string('fecha_fin');
            $table->text('enlace_evidencia');
            $table->unsignedBigInteger('id_rubrica_evaluacion_credito');
            $table->foreign('id_rubrica_evaluacion_credito')->references('id')->on('rubrica_evaluacion_credito');
            $table->text('comentario')->nullable();
            $table->unsignedBigInteger('id_periodo');
            $table->foreign('id_periodo')->references('id')->on('periodo');
            $table->smallInteger('estatus')->default(1);
            $table->smallInteger('edicion')->default(0);
            $table->timestamps();
            /* Estatus del credito */
            /* 
                1 -> Espera => Enviado para ser revisado por el responsable de la actividad complementaria
                2 -> No valido => Rechazado por el responsable de la actividad complementaria
                3 -> Espera => Enviado para ser revisado por proyecto docencia
                4 -> No valido => Rechazado por proyecto docencia
                5 -> Valido => Crédito complementario validado
            */
            /* Estatus Edicion */
            /*  
                0 -> No puede editar 
                1 -> Edita los campos principales (fecha_inicio, fecha_fin, enlace_evidencia)
                2 -> Edita la actividad complementaria del catalogo (id_credito_complementario)
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
        Schema::dropIfExists('actividades_registradas');
    }
}
