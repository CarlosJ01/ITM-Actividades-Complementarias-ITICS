<?php

namespace App\Http\Controllers\Alumno;

use App\Models\CreditosComplementarios\CreditoComplementario;
use App\Models\SGE\Departamento;
use App\Models\ExpedienteCreditos\ActividadRegistrada;
use App\Models\CreditosComplementarios\RubricaEvaluacion;
use App\Models\SGE\Periodo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Validator;

class ActividadesRegistradasController extends Controller {
    /* Vistas */
    /* Agregar un credito - seleccion */
    public function seleccionarCredito(Request $request) {
        $alumno = Auth::user()->alumno;
        try {
            /* Saber cuantos creditos tiene un alumno */
            $numeroCreditos = 0;
            foreach ($alumno->expedienteCreditos->actividadesRegistradas as $actividad) {
                $numeroCreditos += intval($actividad->creditoComplementario->valor);
            }
            /* Si su expediente esta abiero y tiene menos de cinco creditos */
            if (count($alumno->expedienteCreditos->actividadesRegistradas) < 5 && $alumno->expedienteCreditos->estatus && $numeroCreditos < 5) {
                /* Lista de creditos de su departamanento */
                $creditos = $alumno->carrera->departamento->creditosComplementarios;
                /* Credito Seleccionado */
                $creditoSeleccionado = 0;
                if ($request->credito) {
                    $creditoSeleccionado = $request->credito;
                } else {
                    foreach ($creditos as $credito) {
                        if ($credito->valor != 0) {
                            $creditoSeleccionado = $credito->id;
                            break;
                        }
                    }
                }
                return view('alumno.seleccionarCredito', compact('creditos', 'creditoSeleccionado'));
            }
        } catch (\Throwable $th) {
        }
    }
    /* Agregar un credito - informacion */
    public function registrarActividad(Request $request) {
        $alumno = Auth::user()->alumno;
        try {
            /* Saber cuantos creditos tiene un alumno */
            $numeroCreditos = 0;
            foreach ($alumno->expedienteCreditos->actividadesRegistradas as $actividad) {
                $numeroCreditos += intval($actividad->creditoComplementario->valor);
            }
            /* Si su expediente esta abiero y tiene menos de cinco creditos */
            if (count($alumno->expedienteCreditos->actividadesRegistradas) < 5 && $alumno->expedienteCreditos->estatus && $numeroCreditos < 5) {
                /* Validacion de un credito seleccionado */
                $this->validate(request(), [
                    'credito' => 'required|numeric'
                ]);
                /* Informacion del credito y si se ocupa concatenar un complemento */
                if ($credito = CreditoComplementario::where([['id', $request->credito], ['activo', true]])->first()) {
                    if (isset(explode(".", $credito->numero)[1])) {
                        $credito->descripcion = 
                            CreditoComplementario::where([
                                ['numero', intval($credito->numero)], 
                                ['id_departamento', $credito->id_departamento],
                                ['activo', true]
                            ])->first()->descripcion.'; '.$credito->descripcion;
                    }
                    /* Departamentos */
                    $departamentos = Departamento::all();
                    return view('alumno.agregarCredito', compact('credito', 'departamentos'));
                }
            }
        } catch (\Throwable $th) {
        }
    }
    /* Editar un credito registrado */
    public function editarActividad(Request $request) {
        $alumno = Auth::user()->alumno;
        if ($alumno->expedienteCreditos->estatus) {
            $request->actividad = $request->actividad != '' ? $request->actividad : $request->cookie('iace');
            try {
                /* Buscamos la activada registrada */
                foreach ($alumno->expedienteCreditos->actividadesRegistradas as $actividad) {
                    if ($actividad->id == $request->actividad) {
                        if ($actividad->estatus == 2 || $actividad->estatus == 4) {
                            if ($actividad->edicion == 1) {
                                $credito = $actividad->creditoComplementario;
                                if (isset(explode(".", $credito->numero)[1])) {
                                    $actividad->creditoComplementario->descripcion = 
                                        CreditoComplementario::where([
                                            ['numero', intval($credito->numero)], 
                                            ['id_departamento', $credito->id_departamento],
                                        ])->first()->descripcion.'; '.$credito->descripcion;
                                }
                                $actividad->rubricaEvaluacion->responsable->departamento;
                                $departamentos = Departamento::all();
                                return view('alumno.editarActividad', compact('actividad', 'departamentos'));
                            } else if ($actividad->edicion == 2) {
                                $creditoSeleccionado = $actividad->id_credito_complementario; 
                                $creditos = $alumno->carrera->departamento->creditosComplementarios;
                                return view('alumno.editarActividad', compact('creditoSeleccionado', 'creditos', 'actividad'));
                            }
                            return;
                        }
                        return;
                    }
                }
            } catch (\Throwable $th) {
            }
        }
    }
    /* Cambiar el modo de edicion */
    public function editarModoEdicion(Request $request) {
        $alumno = Auth::user()->alumno;
        if ($alumno->expedienteCreditos->estatus) {
            $this->validate(request(), [
                'actividad' => 'required|numeric'
            ]);
            try {
                /* Buscamos la activada registrada */
                foreach ($alumno->expedienteCreditos->actividadesRegistradas as $actividad) {
                    if ($actividad->id == $request->actividad) {
                        if ($actividad->estatus == 2 || $actividad->estatus == 4) {
                            $actividad->edicion = $actividad->edicion == 1 ? 2 : 1;
                            $actividad->save();
                            return redirect()->back()->withCookie(cookie('iace', $actividad->id, 30));
                        }
                        return;
                    }
                }
            } catch (\Throwable $th) {
            }
        }
    }

    /* Acciones */
    /* Agregar un credito */
    public function registrarCredito(Request $request) {
        try {
            $alumno = Auth::user()->alumno;
            /* Si su expediente esta abiero y tiene menos de cinco creditos */
            if (count($alumno->expedienteCreditos->actividadesRegistradas) < 5 && $alumno->expedienteCreditos->estatus) {
                /* Validacion de los formularios */
                $validator = Validator::make($request->all(), [
                    'id_credito_complementario' => 'required',
                    'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
                    'fecha_fin' => 'required|date',
                    'enlace_evidencia' => 'required|url',
                    'id_responsable' => 'required'
                ]);
                if($validator->fails()){
                    return redirect()->route('alumno.agregar.credito.informacion', ['credito' => $request->id_credito_complementario])->withErrors($validator->errors()->all());
                }
                /* Se crea la rubrica de evaluacion */
                $rubrica = RubricaEvaluacion::create([
                    'id_responsable' => $request->id_responsable
                ]);
                /* Se registra el credito al alumno */
                ActividadRegistrada::create([
                    'no_de_control' => $alumno->expedienteCreditos->no_de_control,
                    'id_credito_complementario' => $request->id_credito_complementario,
                    'fecha_inicio' => $request->fecha_inicio,
                    'fecha_fin' => $request->fecha_fin,
                    'enlace_evidencia' => $request->enlace_evidencia,
                    'id_rubrica_evaluacion_credito' => $rubrica->id,
                    'comentario' => 'Enviado a ser revisado por el responsable de la actividad complementaria',
                    'id_periodo' => Periodo::where('activo', 'true')->first()->id
                ]);
                return redirect()->route('alumno.expediente')->with('mensaje', 'Crédito complementario registrado correctamente');
            }
        } catch (\Throwable $th) {
        }
    }
    /* Actualizar un credito */
    public function updateCredito(Request $request) {
        try {
            $alumno = Auth::user()->alumno;
            if ($alumno->expedienteCreditos->estatus) {
                $validator = Validator::make($request->all(), [
                    'actividad' => 'required|numeric',
                    'credito' => 'required|numeric'
                ]);
                if($validator->fails()){
                    return redirect()->route('alumno.actividad.credito.editar', ['actividad' => $request->actividad])->withErrors($validator->errors()->all());
                }
                if ($actividad = ActividadRegistrada::findOrFail($request->actividad)) {
                    if ($actividad->estatus == 2 || $actividad->estatus == 4) {
                        $actividad->update([
                            'id_credito_complementario' => $request->credito,
                            'edicion' => 1
                        ]);
                        return redirect()->back()->withCookie(cookie('iace', $actividad->id, 30))->with('mensaje', 'La actividad seleccionada ha sido actualizada');
                    }
                }
            }
        } catch (\Throwable $th) {
        }
    }
    /* Actulizar la actividad complementaria */
    public function updateActividad(Request $request) {
        try {
            $alumno = Auth::user()->alumno;
            if ($alumno->expedienteCreditos->estatus) {
                $validator = Validator::make($request->all(), [
                    'actividad' => 'required|numeric',
                    'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
                    'fecha_fin' => 'required|date',
                    'enlace_evidencia' => 'required|url',
                    'id_responsable' => 'nullable'
                ]);
                if($validator->fails()){
                    return redirect()->route('alumno.actividad.editar', ['actividad' => $request->actividad])->withErrors($validator->errors()->all());
                }
                /* Buscar una de sus actividades */
                foreach ($alumno->expedienteCreditos->actividadesRegistradas as $actividad) {
                    if ($actividad->id == $request->actividad) {
                        if ($actividad->estatus == 2 || $actividad->estatus == 4) {
                            /* Actualiza comunes */
                            $actividad->fecha_inicio = $request->fecha_inicio;
                            $actividad->fecha_fin = $request->fecha_fin;
                            $actividad->enlace_evidencia = $request->enlace_evidencia;
                            $actividad->edicion = 0;
                            /* Cambia los estatus */
                            if ($actividad->estatus == '2') {
                                $actividad->rubricaEvaluacion->id_responsable = $request->id_responsable;
                                $actividad->estatus = 1;
                            } else if ($actividad->estatus == '4') {
                                $actividad->estatus = 3;
                            }
                            $actividad->rubricaEvaluacion->save();
                            $actividad->save();
                            return redirect()->route('alumno.expediente')->with('mensaje', 'La actividad complementaria ha sido actualizada y enviada a revisión nuevamente');
                        }
                        return;
                    }
                }
            }    
        } catch (\Throwable $th) {
        }
    }
}

