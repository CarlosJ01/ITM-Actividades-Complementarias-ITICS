<?php

namespace App\Http\Controllers;

use App\Models\ExpedienteCreditos\Expediente;
use App\Models\CreditosComplementarios\CreditoComplementario;
use App\Models\SGE\Carrera;

use Illuminate\Http\Request;
use Auth;
use Validator;
use Storage;

class SocialEscolaresController extends Controller {
    /* Vistas */
    /* Inicio del jefe de servicio social y de servicios escolares */
    public function inicio() {
        $socialEscolares = Auth::user()->socialEscolares;
        return view('socialEscolares.inicio')->with('socialEscolares', $socialEscolares);
    }
    /* Buscar expediente de un alumno */
    public function buscarExpediente() {
        return view('socialEscolares.buscarExpediente');
    }
    /* Mostrar el expediente de un alumno */
    public function expedienteAlumno($numeroControl) {
        /* Buscar un expediente con el numero de control */
        if ($expediente = Expediente::findOrFail($numeroControl)) {
            $expediente->fecha_apertura = strftime("%d/%m/%Y", strtotime($expediente->fecha_apertura));
            $expediente->url_constancia_liberacion = Storage::url($expediente->url_constancia_liberacion);
            if ($expediente->fecha_cierre)
                $expediente->fecha_cierre = strftime("%d/%m/%Y", strtotime($expediente->fecha_cierre));
            switch ($expediente->estatus) {
                case true:
                    $expediente->datosEstatus = [
                        'nombre' => 'Abierto',
                        'color' => 'text-primary'
                    ];
                    break;
                case false:
                    $expediente->datosEstatus = [
                        'nombre' => 'Cerrado',
                        'color' => 'text-danger'
                    ];
                    break;
            }
            $expediente->numeroActividadesRegistradas = count($expediente->actividadesRegistradas);
            /* Dar formato a los creditos registrados */
            $expediente->numeroCreditosRegistrados = 0;
            foreach ($expediente->actividadesRegistradas as $actividad) {
                $expediente->numeroCreditosRegistrados += intval($actividad->creditoComplementario->valor);
                $actividad->fecha_inicio = strftime("%d/%m/%Y", strtotime($actividad->fecha_inicio));
                $actividad->fecha_fin = strftime("%d/%m/%Y", strtotime($actividad->fecha_fin));
                switch ($actividad->estatus) {
                    case '1':
                        $actividad->datosEstatus = [
                            'nombre' => 'Espera',
                            'color' => 'btn-warning',
                            'descripcion' => 'Enviado para ser revisado por el responsable de la actividad complementaria'
                        ];
                        break;
                    case '2':
                        $actividad->datosEstatus = [
                            'nombre' => 'Rechazo',
                            'color' => 'btn-danger',
                            'descripcion' => 'Rechazado por el responsable de la actividad complementaria'
                        ];
                        break;
                    case '3':
                        $actividad->datosEstatus = [
                            'nombre' => 'Espera',
                            'color' => 'btn-warning',
                            'descripcion' => 'Enviado para ser revisado por proyecto docencia'
                        ];
                        break;
                    case '4':
                        $actividad->datosEstatus = [
                            'nombre' => 'Rechazo',
                            'color' => 'btn-danger',
                            'descripcion' => 'Rechazado por proyecto docencia'
                        ];
                        break;
                    case '5':
                        $actividad->datosEstatus = [
                            'nombre' => 'Valido',
                            'color' => 'btn-success',
                            'descripcion' => 'Actividad complementaria validada'
                        ];
                        break;
                    default:
                        $actividad->datosEstatus = [
                            'nombre' => '',
                            'color' => '',
                            'descripcion' => ''
                        ];
                        break;
                }
                $actividad->creditoComplementario;
                if (isset(explode(".", $actividad->creditoComplementario->numero)[1])) {
                    $actividad->creditoComplementario->descripcion =
                        CreditoComplementario::where([
                            ['numero', intval($actividad->creditoComplementario->numero)],
                            ['id_departamento', $actividad->creditoComplementario->id_departamento]
                        ])->first()->descripcion . '; ' . $actividad->creditoComplementario->descripcion;
                }
            }

            return view('socialEscolares.expedienteAlumno')->with(['expediente' => $expediente, 'alumno' => $expediente->alumno]);
        }
    }
    /* Expedientes cerrados y filtros del mismo */
    public function expedientesCerrados(Request $request) {
        /* Extraer todas las carreras */
        $carreras = Carrera::all();
        /* Condicion cuando no hay filtro */
        if ($request->carrera == null && $request->semestre == null && $request->fechaInicio == null && $request->fechaFin == null) {
            return view('socialEscolares.expedientesCerrados')->with(['carreras' => $carreras]);
        } else {
            /* Condicion para que se envien las dos fechas */
            if (($request->fechaInicio != null && $request->fechaFin == null) || ($request->fechaInicio == null && $request->fechaFin != null)) {
                return redirect()->back()->withErrors(['error' => 'Debe seleccionar las fechas de inicio y fin']);
            }

            /* Diferentes combinaciones de los filtros que se pueden enviar */
            if ($request->carrera != null) {
                if ($request->semestre != null) {
                    if ($request->fechaInicio != null && $request->fechaFin != null) {
                        /* Todos los filtros */
                        $expedientes = Expediente::select('expediente_creditos.no_de_control', 'expediente_creditos.fecha_cierre', 'expediente_creditos.promedio_rubricas')
                                    ->join('alumno', 'expediente_creditos.no_de_control', 'alumno.no_de_control')
                                    ->where('expediente_creditos.estatus', false)
                                    ->where('alumno.id_carrera', $request->carrera)
                                    ->where('alumno.semestre', $request->semestre)
                                    ->where('expediente_creditos.fecha_cierre', '>=', $request->fechaInicio)
                                    ->where('expediente_creditos.fecha_cierre', '<=', $request->fechaFin)
                                    ->orderBy('alumno.apellido_paterno')
                                    ->get();
                    } else {
                        /* Filtro carrera y semestre */
                        $expedientes = Expediente::select('expediente_creditos.no_de_control', 'expediente_creditos.fecha_cierre', 'expediente_creditos.promedio_rubricas')
                                    ->join('alumno', 'expediente_creditos.no_de_control', 'alumno.no_de_control')
                                    ->where('expediente_creditos.estatus', false)
                                    ->where('alumno.id_carrera', $request->carrera)
                                    ->where('alumno.semestre', $request->semestre)
                                    ->orderBy('alumno.apellido_paterno')
                                    ->get();
                    }
                } else {
                    if ($request->fechaInicio != null && $request->fechaFin != null) {
                        /* Filtro carrera y fechas */
                        $expedientes = Expediente::select('expediente_creditos.no_de_control', 'expediente_creditos.fecha_cierre', 'expediente_creditos.promedio_rubricas')
                                    ->join('alumno', 'expediente_creditos.no_de_control', 'alumno.no_de_control')
                                    ->where('expediente_creditos.estatus', false)
                                    ->where('alumno.id_carrera', $request->carrera)
                                    ->where('expediente_creditos.fecha_cierre', '>=', $request->fechaInicio)
                                    ->where('expediente_creditos.fecha_cierre', '<=', $request->fechaFin)
                                    ->orderBy('alumno.apellido_paterno')
                                    ->get();
                    } else {
                        /* Filtro solo carrera */
                        $expedientes = Expediente::select('expediente_creditos.no_de_control', 'expediente_creditos.fecha_cierre', 'expediente_creditos.promedio_rubricas')
                                    ->join('alumno', 'expediente_creditos.no_de_control', 'alumno.no_de_control')
                                    ->where('expediente_creditos.estatus', false)
                                    ->where('alumno.id_carrera', $request->carrera)
                                    ->orderBy('alumno.apellido_paterno')
                                    ->get();
                    }
                }
            } else {
                if ($request->semestre != null) {
                    if ($request->fechaInicio != null && $request->fechaFin != null) {
                        /* Filtro semestre y fechas */
                        $expedientes = Expediente::select('expediente_creditos.no_de_control', 'expediente_creditos.fecha_cierre', 'expediente_creditos.promedio_rubricas')
                                    ->join('alumno', 'expediente_creditos.no_de_control', 'alumno.no_de_control')
                                    ->where('expediente_creditos.estatus', false)
                                    ->where('alumno.semestre', $request->semestre)
                                    ->where('expediente_creditos.fecha_cierre', '>=', $request->fechaInicio)
                                    ->where('expediente_creditos.fecha_cierre', '<=', $request->fechaFin)
                                    ->orderBy('alumno.apellido_paterno')
                                    ->get();
                    } else {
                        /* Filtro solo semestre */
                        $expedientes = Expediente::select('expediente_creditos.no_de_control', 'expediente_creditos.fecha_cierre', 'expediente_creditos.promedio_rubricas')
                                    ->join('alumno', 'expediente_creditos.no_de_control', 'alumno.no_de_control')
                                    ->where('expediente_creditos.estatus', false)
                                    ->where('alumno.semestre', $request->semestre)
                                    ->orderBy('alumno.apellido_paterno')
                                    ->get();
                    }
                } else {
                    if ($request->fechaInicio != null && $request->fechaFin != null) {
                        /* Filtro solo fechas */
                        $expedientes = Expediente::select('expediente_creditos.no_de_control', 'expediente_creditos.fecha_cierre', 'expediente_creditos.promedio_rubricas')
                                    ->join('alumno', 'expediente_creditos.no_de_control', 'alumno.no_de_control')
                                    ->where('expediente_creditos.estatus', false)
                                    ->where('expediente_creditos.fecha_cierre', '>=', $request->fechaInicio)
                                    ->where('expediente_creditos.fecha_cierre', '<=', $request->fechaFin)
                                    ->orderBy('alumno.apellido_paterno')
                                    ->get();
                    }
                }
            }

            /* Formato de datos para la tabla */
            foreach ($expedientes as $expediente) {
                $expediente->alumno->carrera;
                $expediente->fecha_cierre = strftime("%d/%m/%Y", strtotime($expediente->fecha_cierre));
            }

            /* Regresar a la vista con los datos */
            return view('socialEscolares.expedientesCerrados')
            ->with([
                'carreras' => $carreras,
                'expedientes' => $expedientes,
                'filtro' => [
                    'carrera' => $request->carrera,
                    'semestre' => $request->semestre,
                    'fechaInicio' => $request->fechaInicio,
                    'fechaFin' => $request->fechaFin,
                ]
            ]);
        }
    }

    /* Acciones */
    /* Buscar si existe un expediente con el numero de control dado */
    public function buscarExpedienteAlumno(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'numeroControl' => 'required'
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors()->all())->withInput();
            }
            /* Buscar un expediente con el numero de control */
            if ($expediente = Expediente::where('no_de_control', $request->numeroControl)->first()) {
                return redirect()->route('socialEscolares.expediente.alumno', ['numeroControl' => $request->numeroControl]);
            } else {
                return redirect()->back()->withErrors(['error' => 'No se encontró un expediente de créditos complementarios con el número de control '.$request->numeroControl])->withInput();
            }
        } catch (\Throwable $th) {
        }
    }
}
