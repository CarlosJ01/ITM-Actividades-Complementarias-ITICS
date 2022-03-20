<?php

namespace App\Models\SGE;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumno';
    protected $primaryKey = 'no_de_control';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    /* Expediente de creditos complementarios */
    public function expedienteCreditos(){
        return $this->hasOne('App\Models\ExpedienteCreditos\Expediente', 'no_de_control');
    }
    /* Carrera */
    public function carrera() {
        return $this->hasOne('App\Models\SGE\Carrera', 'id', 'id_carrera');
    }
}
