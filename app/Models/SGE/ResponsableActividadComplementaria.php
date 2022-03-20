<?php

namespace App\Models\SGE;

use Illuminate\Database\Eloquent\Model;

class ResponsableActividadComplementaria extends Model
{
    protected $table = 'responsable_actividad_complementaria';
    protected $primaryKey = 'id';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    /* Relacion con departamento */
    public function departamento() {
        return $this->hasOne('App\Models\SGE\Departamento', 'id', 'id_departamento');
    }

    /* Rubricas */
    public function rubricas(){
        return $this->hasMany('App\Models\CreditosComplementarios\RubricaEvaluacion', 'id_responsable', 'id')->orderByDesc('updated_at');
    }
}
