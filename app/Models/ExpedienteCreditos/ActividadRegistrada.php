<?php

namespace App\Models\ExpedienteCreditos;

use Illuminate\Database\Eloquent\Model;

class ActividadRegistrada extends Model
{
    protected $table = 'actividades_registradas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'no_de_control',
        'id_credito_complementario',
        'fecha_inicio',
        'fecha_fin',
        'enlace_evidencia',
        'id_rubrica_evaluacion_credito',
        'comentario',
        'estatus',
        'id_periodo',
        'edicion'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /* Credito complementario */
    public function creditoComplementario() {
        return $this->hasOne('App\Models\CreditosComplementarios\CreditoComplementario', 'id', 'id_credito_complementario');        
    }
    /* Relacion con la rubrica de evaluacion */
    public function rubricaEvaluacion(){
        return $this->hasOne('App\Models\CreditosComplementarios\RubricaEvaluacion', 'id', 'id_rubrica_evaluacion_credito');   
    }
    /* Alumno */
    public function alumno() {
        return $this->belongsTo('App\Models\SGE\Alumno', 'no_de_control', 'no_de_control');
    }
    /* Expediente */
    public function expediente() {
        return $this->belongsTo('App\Models\ExpedienteCreditos\Expediente', 'no_de_control', 'no_de_control');
    }
}
