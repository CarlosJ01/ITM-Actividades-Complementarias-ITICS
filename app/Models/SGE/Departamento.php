<?php

namespace App\Models\SGE;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamento';
    protected $primaryKey = 'id';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /* Creditos del departamento */
    public function creditosComplementarios() {
        return $this->hasMany('App\Models\CreditosComplementarios\CreditoComplementario', 'id_departamento')->where('activo', true)->orderBy('numero');
    }

    public function carreras() {
        return $this->hasMany('App\Models\SGE\Carrera', 'id_departamento')->orderBy('nombre');
    }
}
