<?php

namespace App\Http\Controllers\ResponsableActividad;

use App\Models\CreditosComplementarios\RubricaEvaluacion;
use App\Models\CreditosComplementarios\CreditoComplementario;
use App\Models\SGE\Alumno;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;

class RubricaEvaluacionController extends Controller {
    /* Vistas */
    /* Mostrar la rubrica de evaluacion de un alumno */
    public function rubricaEvaluacionAlumno(Request $request) {
        try {
            /* Validacion del request */
            $validator = Validator::make($request->all(), [
                'idRubrica' => 'required'
            ]);

            if ($rubrica = RubricaEvaluacion::findOrFail($request->idRubrica)) {
                if ($rubrica->estatus) {
                    if ($rubrica->actividadRegistrada != null) {
                        /* Datos de la rubrica - alumno */
                        $datosRubrica = [
                            'nombreAlumno' => Auth::user()->alumno->nombre.' '.Auth::user()->alumno->apellido_paterno.' '.(Auth::user()->alumno->apellido_materno ? Auth::user()->alumno->apellido_materno : ''),
                            'numeroControl' => Auth::user()->alumno->no_de_control,
                            'nombreResponsable' => $rubrica->responsable->nombre.' '.$rubrica->responsable->apellido_paterno.' '.($rubrica->responsable->apellido_materno ? $rubrica->responsable->apellido_materno : '')
                        ];

                        /* Datos de la rubrica - actividad */
                        $actividad = $rubrica->actividadRegistrada;
                        if (isset(explode(".", $actividad->creditoComplementario->numero)[1])) {
                            $actividad->creditoComplementario->descripcion = CreditoComplementario::where([
                                                                                ['numero', intval($actividad->creditoComplementario->numero)], 
                                                                                ['id_departamento', $actividad->creditoComplementario->id_departamento]])->first()
                                                                                ->descripcion.'; '.$actividad->creditoComplementario->descripcion;
                        }
                        $datosRubrica['actividad'] = $actividad->creditoComplementario->descripcion;
                        $datosRubrica['periodo'] = strftime("%d/%m/%Y", strtotime($actividad->fecha_inicio)).' - '.strftime("%d/%m/%Y", strtotime($actividad->fecha_fin));

                        /* Desempeño de la actividad */
                        $rubrica->desempenio = '';
                        if ($rubrica->valor >= 0.00 && $rubrica->valor <= 0.99) {
                            $rubrica->desempenio = 'Insuficiente';
                        } else {
                            if ($rubrica->valor >= 1.00 && $rubrica->valor <= 1.49) {
                                $rubrica->desempenio = 'Suficiente';
                            } else {
                                if ($rubrica->valor >= 1.50 && $rubrica->valor <= 2.49) {
                                    $rubrica->desempenio = 'Bueno';
                                } else {
                                    if ($rubrica->valor >= 2.50 && $rubrica->valor <= 3.49) {
                                        $rubrica->desempenio = 'Notable';
                                    } else {
                                        if ($rubrica->valor >= 3.50 && $rubrica->valor <= 4.00) {
                                            $rubrica->desempenio = 'Excelente';
                                        }
                                    }
                                }
                            }
                        }
                        return view('alumno.rubricaEvaluacion', compact('rubrica', 'datosRubrica'));
                    }
                } else {
                    return view('alumno.sinRubrica')->with('responsable', $rubrica->responsable);
                }
            }
        } catch (\Throwable $th) {
        }
    }

    /* Evaluar rubrica individual */
    public function rubricaIndividual($rubrica) {
        try {
            if ($rubrica = RubricaEvaluacion::findOrFail($rubrica)) {
                if (! $rubrica->estatus) {
                    if ($rubrica->id_responsable == Auth::user()->responsableActividad->id) {
                        $alumno = $rubrica->actividadRegistrada->alumno;
                        $datosRubrica = [
                            'nombreAlumno' => $alumno->nombre.' '.$alumno->apellido_paterno.' '.($alumno->apellido_materno ? $alumno->apellido_materno : ''),
                            'numeroControl' => $alumno->no_de_control,
                        ];
    
                        $actividad = $rubrica->actividadRegistrada;
                        if (isset(explode(".", $actividad->creditoComplementario->numero)[1])) {
                            $actividad->creditoComplementario->descripcion = 
                                CreditoComplementario::where([
                                    ['numero', intval($actividad->creditoComplementario->numero)], 
                                    ['id_departamento', $actividad->creditoComplementario->id_departamento]])->first()
                                    ->descripcion.'; '.$actividad->creditoComplementario->descripcion;
                        }
                        $datosRubrica['actividad'] = $actividad->creditoComplementario->descripcion;
                        $datosRubrica['valor'] = $actividad->creditoComplementario->valor;
                        $datosRubrica['periodo'] = strftime("%d/%m/%Y", strtotime($actividad->fecha_inicio)).' - '.strftime("%d/%m/%Y", strtotime($actividad->fecha_fin));
    
                        return view('responsableActividad.actividades.rubricaIndividual')->with([
                            'datos' => $datosRubrica,
                            'actividad' => $actividad->id_credito_complementario,
                            'rubrica' => $rubrica->id
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
        }
    }

    /* Evaluar rubricas masivamente */
    public function rubricasActividad($credito) {
        try {
            $responsable = Auth::user()->responsableActividad;
            $actividad = CreditoComplementario::findOrFail($credito);
            $alumnos =  DB::table('responsable_actividad_complementaria')
                            ->select('alumno.no_de_control', 'alumno.nombre', 'alumno.apellido_paterno',
                                    'alumno.apellido_materno', 'rubrica_evaluacion_credito.id AS idRubrica')
                            ->join('rubrica_evaluacion_credito', 'responsable_actividad_complementaria.id', '=', 'rubrica_evaluacion_credito.id_responsable')
                            ->join('actividades_registradas', 'rubrica_evaluacion_credito.id', '=', 'actividades_registradas.id_rubrica_evaluacion_credito')
                            ->join('alumno', 'actividades_registradas.no_de_control', '=', 'alumno.no_de_control')
                            ->where('responsable_actividad_complementaria.id', '=', $responsable->id)
                            ->where('actividades_registradas.id_credito_complementario', '=', $actividad->id)
                            ->where('actividades_registradas.estatus', '=', '1')
                            ->where('rubrica_evaluacion_credito.estatus', '=','0')
                            ->orderBy('alumno.no_de_control')
                            ->get();
            if (count($alumnos) == 0) {
                return redirect()->route('responsable.actividades');
            }
            /* Condicion para creditos que son subcreditos de otros */
            if (isset(explode(".", $actividad->numero)[1])) {
                /* Buscar si el expediente encontrado es de uno de su departamento */
                $actividad->descripcion = 
                    CreditoComplementario::where([
                        ['numero', intval($actividad->numero)], 
                        ['id_departamento', $actividad->id_departamento]
                    ])->first()->descripcion.'; '.$actividad->descripcion;
            }

            return view('responsableActividad.actividades.rubricaMasiva')->with([
                                'alumnos' => $alumnos,
                                'actividad' => $actividad
                            ]);    
        } catch (\Throwable $th) {
        }
    }

    /* Mostrar la rubrica de evaluacion para docencia */
    public function rubricaEvaluacionDocencia($numeroControl, $rubrica) {
        if ($rubrica = RubricaEvaluacion::findOrFail($rubrica)) {
            if ($rubrica->estatus) {
                if ($rubrica->actividadRegistrada != null) {
                    /* Datos de la rubrica - alumno */
                    $alumno = Alumno::findOrFail($numeroControl);
                    $datosRubrica = [
                        'nombreAlumno' => $alumno->nombre.' '.$alumno->apellido_paterno.' '.($alumno->apellido_materno ? $alumno->apellido_materno : ''),
                        'numeroControl' => $alumno->no_de_control,
                        'nombreResponsable' => $rubrica->responsable->nombre.' '.$rubrica->responsable->apellido_paterno.' '.($rubrica->responsable->apellido_materno ? $rubrica->responsable->apellido_materno : '')
                    ];

                    /* Datos de la rubrica - actividad */
                    $actividad = $rubrica->actividadRegistrada;
                    if (isset(explode(".", $actividad->creditoComplementario->numero)[1])) {
                        $actividad->creditoComplementario->descripcion = CreditoComplementario::where([
                                                                            ['numero', intval($actividad->creditoComplementario->numero)], 
                                                                            ['id_departamento', $actividad->creditoComplementario->id_departamento]])->first()
                                                                            ->descripcion.'; '.$actividad->creditoComplementario->descripcion;
                    }
                    $datosRubrica['actividad'] = $actividad->creditoComplementario->descripcion;
                    $datosRubrica['periodo'] = strftime("%d/%m/%Y", strtotime($actividad->fecha_inicio)).' - '.strftime("%d/%m/%Y", strtotime($actividad->fecha_fin));

                    /* Desempeño de la actividad */
                    $rubrica->desempenio = '';
                    if ($rubrica->valor >= 0.00 && $rubrica->valor <= 0.99) {
                        $rubrica->desempenio = 'Insuficiente';
                    } else {
                        if ($rubrica->valor >= 1.00 && $rubrica->valor <= 1.49) {
                            $rubrica->desempenio = 'Suficiente';
                        } else {
                            if ($rubrica->valor >= 1.50 && $rubrica->valor <= 2.49) {
                                $rubrica->desempenio = 'Bueno';
                            } else {
                                if ($rubrica->valor >= 2.50 && $rubrica->valor <= 3.49) {
                                    $rubrica->desempenio = 'Notable';
                                } else {
                                    if ($rubrica->valor >= 3.50 && $rubrica->valor <= 4.00) {
                                        $rubrica->desempenio = 'Excelente';
                                    }
                                }
                            }
                        }
                    }
                    return view('proyectoDocencia.expediente.rubricaEvaluacion')->with(['rubrica' => $rubrica, 'datosRubrica' => $datosRubrica, 'numeroControl' => $numeroControl]);;
                }
            } else {
                return view('proyectoDocencia.expediente.sinRubrica')->with(['numeroControl' => $numeroControl, 'responsable' => $rubrica->responsable]);
            }
        }
    }
}
