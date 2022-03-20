<?php

namespace App\Models\SGE;

use Illuminate\Database\Eloquent\Model;

class ProyectoDocencia extends Model
{
    protected $table = 'proyecto_docencia';
    protected $primaryKey = 'id';

    /*Relacion con departamento*/
    public function departamento() {
        return $this->hasOne('App\Models\SGE\Departamento', 'id', 'id_departamento');
    }
}
