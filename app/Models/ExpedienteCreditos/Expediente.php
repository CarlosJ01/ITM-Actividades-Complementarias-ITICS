<?php

namespace App\Models\ExpedienteCreditos;

use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    protected $table = 'expediente_creditos';
    protected $primaryKey = 'no_de_control';

    protected $fillable = [
        'no_de_control',
        'fecha_apertura',
        'fecha_cierre',
        'creditos',
        'promedio_rubricas',
        'url_constancia_liberacion',
        'estatus',
        'id_periodo'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /* Creditos complementarios registrados */
    public function actividadesRegistradas(){
        return $this->hasMany('App\Models\ExpedienteCreditos\ActividadRegistrada', 'no_de_control', 'no_de_control')->orderByDesc('updated_at');
    }
    /* Creditos complementarios registrados con estatus 3 */
    public function ultimaActividad(){
        return $this->hasMany('App\Models\ExpedienteCreditos\ActividadRegistrada', 'no_de_control', 'no_de_control')->where('estatus', '3')->orderByDesc('updated_at');
    }
    /* Alumno */
    public function alumno() {
        return $this->belongsTo('App\Models\SGE\Alumno', 'no_de_control', 'no_de_control');
    }
}
