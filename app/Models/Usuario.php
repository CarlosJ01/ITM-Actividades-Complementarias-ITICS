<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre', 'password', 'default'
    ];

    protected $hidden = [
        'password',
    ];
    
    /* Funciones para obtener los datos segun el tipo de usuario */
    public function alumno(){
        return $this->hasOne('App\Models\SGE\Alumno', 'id_usuario');
    }
    public function proyectoDocencia(){
        return $this->hasOne('App\Models\SGE\ProyectoDocencia', 'id_usuario');
    }
    public function responsableActividad(){
        return $this->hasOne('App\Models\SGE\ResponsableActividadComplementaria', 'id_usuario');
    }
    public function socialEscolares(){
        return $this->hasOne('App\Models\SGE\ServicioSocialEscolares', 'id_usuario');
    }
    /* Funcion para verificar que tipo de usurio tiene */
    public function tipoUsuario(){
        /* A = Alumno - R = Responsable - D = Docencia - O = Otro*/
        if ($this->alumno)
            return 'A';
        if ($this->responsableActividad)
            return 'R';
        if ($this->proyectoDocencia)
            return 'D';
        if ($this->socialEscolares)
            return 'SE'; 
        return 'O';
    }
}
