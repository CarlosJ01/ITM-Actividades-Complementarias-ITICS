<?php

namespace App\Http\Controllers\Alumno;

use App\Models\ExpedienteCreditos\CreditosRegistrados;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AlumnoController extends Controller {
    /* Paguina de inicio */
    public function inicio(){
        $alumno = Auth::user()->alumno;
        return view('alumno.inicio', compact('alumno'));
    }
}
