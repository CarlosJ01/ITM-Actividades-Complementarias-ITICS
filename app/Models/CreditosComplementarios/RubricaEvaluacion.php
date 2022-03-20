<?php

namespace App\Models\CreditosComplementarios;

use Illuminate\Database\Eloquent\Model;

class RubricaEvaluacion extends Model
{
    protected $table = 'rubrica_evaluacion_credito';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'criterio_1',
        'criterio_2',
        'criterio_3',
        'criterio_4',
        'criterio_5',
        'criterio_6',
        'criterio_7',
        'observaciones',
        'valor',
        'id_responsable',
        'estatus'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /* Responsable de la actividad */
    public function responsable() {
        return $this->hasOne('App\Models\SGE\ResponsableActividadComplementaria', 'id', 'id_responsable');
    }
    /* Actividad a la que pertenece */
    public function actividadRegistrada(){
        return $this->belongsTo('App\Models\ExpedienteCreditos\ActividadRegistrada', 'id', 'id_rubrica_evaluacion_credito');
    }
}
