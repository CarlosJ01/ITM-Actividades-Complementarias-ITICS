<?php

namespace App\Models\CreditosComplementarios;

use Illuminate\Database\Eloquent\Model;

class CreditoComplementario extends Model
{
    protected $table = 'credito_complementario';
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
