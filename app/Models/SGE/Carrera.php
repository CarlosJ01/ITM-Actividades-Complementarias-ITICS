<?php

namespace App\Models\SGE;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'carrera';
    protected $primaryKey = 'id';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    /* Departamento */
    public function departamento() {
        return $this->hasOne('App\Models\SGE\Departamento', 'id', 'id_departamento');
    }
}
