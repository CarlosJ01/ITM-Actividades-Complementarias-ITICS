<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditoComplementarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credito_complementario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('numero', 8, 2);
            $table->text('descripcion');
            $table->smallInteger('valor');
            $table->unsignedBigInteger('id_departamento');
            $table->foreign('id_departamento')->references('id')->on('departamento');
            $table->boolean('activo')->default(true);
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
        Schema::dropIfExists('credito_complementario');
    }
}
