<?php

namespace App\Http\Controllers\ProyectoDocencia;

use App\Models\ExpedienteCreditos\Expediente;
use App\Models\CreditosComplementarios\CreditoComplementario;
use App\Models\ExpedienteCreditos\ActividadRegistrada;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SGE\Carrera;
use Auth;
use Validator;
use Storage;

class ProyectoDocenciaController extends Controller
{
    /* Vistas */
    /* Vista del inicio de sesion del proyecto docencia */
    public function inicio() {
        $docencia = Auth::user()->proyectoDocencia;
        return view('proyectoDocencia.inicio')->with(['docencia' => $docencia]);
    }
    /* Vista para buscar el expediente de un alumno por numero de control */
    public function buscarExpedienteAlumno() {
        return view('proyectoDocencia.buscarExpediente');
    }
    /* Vista para buscar los expedientes por carrera */
    public function buscarExpedientesCarrera() {
        $docencia = Auth::user()->proyectoDocencia;
        if ($docencia->departamento->carreras->count() > 1) {
            $carreras = $docencia->departamento->carreras;
            return view('proyectoDocencia.buscarCarrera')->with(['carreras' => $carreras]);
        } else {
            return redirect()->route('docencia.expediente.carrera', ['carrera' => $docencia->departamento->carreras[0]->id]);
        }
    }
    /* Vista para buscar los expedientes por estatus */
    public function buscarExpedientesGeneral() {
        return view('proyectoDocencia.buscarExpedientes');
    }
    /* Vista para buscar los expedientes por estatus */
    public function buscarExpedientesPendientes() {
        if ($expedientes = Expediente::select('expediente_creditos.*', 'alumno.*', 'carrera.nombre as nombre_carrera')
            ->selectRaw('COUNT(*) AS numero_act')
            ->join('alumno', 'alumno.no_de_control', 'expediente_creditos.no_de_control')
            ->join('carrera', 'carrera.id', 'alumno.id_carrera')
            ->join('proyecto_docencia', 'proyecto_docencia.id_departamento', 'carrera.id_departamento')
            ->join('actividades_registradas', 'actividades_registradas.no_de_control', 'alumno.no_de_control')
            ->where('actividades_registradas.estatus', '3')
            ->where('proyecto_docencia.id', Auth::user()->proyectoDocencia->id)
            ->orderBy('expediente_creditos.updated_at', 'desc')
            ->groupBy('expediente_creditos.no_de_control')
            ->groupBy('alumno.no_de_control')
            ->groupBy('carrera.nombre')
            ->get()
        ) {
            $semestres = [];
            foreach ($expedientes as $expediente) {
                /* Buscar si el expediente encontrado es de uno de su departamento */
                $expediente->fecha_apertura = strftime("%d/%m/%Y", strtotime($expediente->fecha_apertura));
                if ($expediente->fecha_cierre)
                    $expediente->fecha_cierre = strftime("%d/%m/%Y", strtotime($expediente->fecha_cierre));
                switch ($expediente->estatus) {
                    case true:
                        $expediente->datosEstatus = [
                            'nombre' => 'Abierto',
                            'color' => 'btn-primary'
                        ];
                        break;
                    case false:
                        $expediente->datosEstatus = [
                            'nombre' => 'Cerrado',
                            'color' => 'btn-danger'
                        ];
                        break;
                }
                $expediente->numeroActividadesRegistradas = count($expediente->actividadesRegistradas);
                $expediente->actualizacion=substr($expediente->actualizacion,0,10);
            }
            $data = [];
            $docencia = Auth::user()->proyectoDocencia;
            if ($docencia->departamento->carreras->count() > 1) {
                $carreras = $docencia->departamento->carreras;
                return view('proyectoDocencia.buscarPendientes')->with(['expedientes' => $expedientes, 'carreras' => $carreras, 'data' => $data]);
            }
            return view('proyectoDocencia.buscarPendientes')->with(['expedientes' => $expedientes, 'data' => $data]);
        }
    }
    /* Buscar expediente de un alumno por su numero de control y ver el expediente de un alumno */
    public function expedienteAlumno($numeroControl) {
        /* Buscar un expediente con el numero de control */
        if ($expediente = Expediente::findOrFail($numeroControl)) {
            /* Buscar si el expediente encontrado es de uno de su departamento */
            if (Auth::user()->proyectoDocencia->id_departamento == $expediente->alumno->carrera->id_departamento) {
                $expediente->fecha_apertura = strftime("%d/%m/%Y", strtotime($expediente->fecha_apertura));
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
                return view('proyectoDocencia.expediente.index')->with(['expediente' => $expediente, 'alumno' => $expediente->alumno]);
            }
        }
    }
    /* Buscar expedientes de los alumnos por carrera */
    public function expedienteCarrera($id_carrera) {
        /* Buscar expedientes de la carrera */
        if ($expedientes = Expediente::select('expediente_creditos.*', 'alumno.*')
            ->join('alumno', 'alumno.no_de_control', 'expediente_creditos.no_de_control')
            ->join('carrera', 'carrera.id', 'alumno.id_carrera')
            ->join('proyecto_docencia', 'proyecto_docencia.id_departamento', 'carrera.id_departamento')
            ->where('carrera.id', $id_carrera)
            ->where('proyecto_docencia.id', Auth::user()->proyectoDocencia->id)
            ->orderBy('expediente_creditos.updated_at', 'desc')
            ->get()
        ) {
            foreach ($expedientes as $expediente) {
                /* Buscar si el expediente encontrado es de uno de su departamento */
                $expediente->fecha_apertura = strftime("%d/%m/%Y", strtotime($expediente->fecha_apertura));
                if ($expediente->fecha_cierre)
                    $expediente->fecha_cierre = strftime("%d/%m/%Y", strtotime($expediente->fecha_cierre));
                switch ($expediente->estatus) {
                    case true:
                        $expediente->datosEstatus = [
                            'nombre' => 'Abierto',
                            'color' => 'btn-primary'
                        ];
                        break;
                    case false:
                        $expediente->datosEstatus = [
                            'nombre' => 'Cerrado',
                            'color' => 'btn-danger'
                        ];
                        break;
                }
                $expediente->numeroActividadesRegistradas = count($expediente->actividadesRegistradas);
                $expediente->actualizacion=substr($expediente->actualizacion,0,10);
            }
            $carrera = Carrera::findOrFail($id_carrera);
            return view('proyectoDocencia.expedienteCarrera')->with(['expedientes' => $expedientes, 'carrera' => $carrera]);
        }
    }
    /* Buscar expedientes registrados filtrados por el estatus */
    public function expedientes($estatus)
    {
        /* Buscar expedientes por su estatus */
        if ($expedientes = Expediente::select('expediente_creditos.*', 'alumno.*')
            ->join('alumno', 'alumno.no_de_control', 'expediente_creditos.no_de_control')
            ->join('carrera', 'carrera.id', 'alumno.id_carrera')
            ->join('proyecto_docencia', 'proyecto_docencia.id_departamento', 'carrera.id_departamento')
            ->where('proyecto_docencia.id', Auth::user()->proyectoDocencia->id)
            ->where('expediente_creditos.estatus', $estatus)
            ->orderBy('expediente_creditos.updated_at', 'desc')
            ->get()
        ) {
            foreach ($expedientes as $expediente) {
                /* Buscar si el expediente encontrado es de uno de su departamento */
                $expediente->fecha_apertura = strftime("%d/%m/%Y", strtotime($expediente->fecha_apertura));
                if ($expediente->fecha_cierre)
                    $expediente->fecha_cierre = strftime("%d/%m/%Y", strtotime($expediente->fecha_cierre));
                switch ($expediente->estatus) {
                    case true:
                        $expediente->datosEstatus = [
                            'nombre' => 'Abierto',
                            'color' => 'btn-primary'
                        ];
                        break;
                    case false:
                        $expediente->datosEstatus = [
                            'nombre' => 'Cerrado',
                            'color' => 'btn-danger'
                        ];
                        break;
                }
                $expediente->numeroActividadesRegistradas = count($expediente->actividadesRegistradas);
            }
            return view('proyectoDocencia.expedientes')->with(['expedientes' => $expedientes, 'estatus' => $estatus]);
        }
    }

    public function filtroPendientes($fecha_inicio, $fecha_fin, $semestre = null, $carrera = null)
    {
        if ($semestre != null) { /* Existe semestre */
            if ($carrera != null) { /* Existe carrera*/
                $expedientes = Expediente::select('expediente_creditos.*', 'alumno.*', 'carrera.nombre as nombre_carrera')
                    ->selectRaw('COUNT(*) AS numero_act')
                    ->join('alumno', 'alumno.no_de_control', 'expediente_creditos.no_de_control')
                    ->join('carrera', 'carrera.id', 'alumno.id_carrera')
                    ->join('proyecto_docencia', 'proyecto_docencia.id_departamento', 'carrera.id_departamento')
                    ->join('actividades_registradas', 'actividades_registradas.no_de_control', 'alumno.no_de_control')
                    ->where('actividades_registradas.estatus', '3')
                    ->where('proyecto_docencia.id', Auth::user()->proyectoDocencia->id)
                    ->where('alumno.semestre', $semestre)
                    ->where('alumno.id_carrera', $carrera)
                    ->where('actividades_registradas.updated_at', '>=', $fecha_inicio." 00:00:01")
                    ->where('actividades_registradas.updated_at', '<=', $fecha_fin." 23:59:59")
                    ->orderBy('expediente_creditos.updated_at', 'desc')
                    ->groupBy('expediente_creditos.no_de_control')
                    ->groupBy('alumno.no_de_control')
                    ->groupBy('carrera.nombre')
                    ->get();

                $data = array('fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin, 'semestre' => $semestre, 'carrera' => $carrera);
            } else {
                $expedientes = Expediente::select('expediente_creditos.*', 'alumno.*', 'carrera.nombre as nombre_carrera')
                    ->selectRaw('COUNT(*) AS numero_act')
                    ->join('alumno', 'alumno.no_de_control', 'expediente_creditos.no_de_control')
                    ->join('carrera', 'carrera.id', 'alumno.id_carrera')
                    ->join('proyecto_docencia', 'proyecto_docencia.id_departamento', 'carrera.id_departamento')
                    ->join('actividades_registradas', 'actividades_registradas.no_de_control', 'alumno.no_de_control')
                    ->where('actividades_registradas.estatus', '3')
                    ->where('proyecto_docencia.id', Auth::user()->proyectoDocencia->id)
                    ->where('alumno.semestre', $semestre)
                    ->where('actividades_registradas.updated_at', '>=', $fecha_inicio." 00:00:01")
                    ->where('actividades_registradas.updated_at', '<=', $fecha_fin." 23:59:59")
                    ->orderBy('expediente_creditos.updated_at', 'desc')
                    ->groupBy('expediente_creditos.no_de_control')
                    ->groupBy('alumno.no_de_control')
                    ->groupBy('carrera.nombre')
                    ->get();

                $data = array('fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin, 'semestre' => $semestre);
            }
        } else {
            $expedientes = Expediente::select('expediente_creditos.*', 'alumno.*', 'carrera.nombre as nombre_carrera')
                ->selectRaw('COUNT(*) AS numero_act')
                ->join('alumno', 'alumno.no_de_control', 'expediente_creditos.no_de_control')
                ->join('carrera', 'carrera.id', 'alumno.id_carrera')
                ->join('proyecto_docencia', 'proyecto_docencia.id_departamento', 'carrera.id_departamento')
                ->join('actividades_registradas', 'actividades_registradas.no_de_control', 'alumno.no_de_control')
                ->where('actividades_registradas.estatus', '3')
                ->where('proyecto_docencia.id', Auth::user()->proyectoDocencia->id)
                ->where('actividades_registradas.updated_at', '>=', $fecha_inicio." 00:00:01")
                ->where('actividades_registradas.updated_at', '<=', $fecha_fin." 23:59:59")
                ->orderBy('expediente_creditos.updated_at', 'desc')
                ->groupBy('expediente_creditos.no_de_control')
                ->groupBy('alumno.no_de_control')
                ->groupBy('carrera.nombre')
                ->get();
            $data = array('fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin);
        }

        if (!empty($expedientes)) {
            foreach ($expedientes as $expediente) {
                /* Buscar si el expediente encontrado es de uno de su departamento */
                $expediente->fecha_apertura = strftime("%d/%m/%Y", strtotime($expediente->fecha_apertura));
                if ($expediente->fecha_cierre)
                    $expediente->fecha_cierre = strftime("%d/%m/%Y", strtotime($expediente->fecha_cierre));
                switch ($expediente->estatus) {
                    case true:
                        $expediente->datosEstatus = [
                            'nombre' => 'Abierto',
                            'color' => 'btn-primary'
                        ];
                        break;
                    case false:
                        $expediente->datosEstatus = [
                            'nombre' => 'Cerrado',
                            'color' => 'btn-danger'
                        ];
                        break;
                }
            }
            $docencia = Auth::user()->proyectoDocencia;
            if ($docencia->departamento->carreras->count() > 1) {
                $carreras = $docencia->departamento->carreras;
                return view('proyectoDocencia.buscarPendientes')->with(['expedientes' => $expedientes, 'carreras' => $carreras, 'data' => $data]);
            }
            return view('proyectoDocencia.buscarPendientes')->with(['expedientes' => $expedientes, 'data' => $data]);
        }
    }
    /* Acciones */
    /* Evaluar una actividad dependiendo de la opcion */
    public function evaluarActividad(Request $request) {
        /* Validaciones */
        $this->validate(request(), [
            'actividad' => 'required|integer',
            'evaluacion' => 'required|integer',
            'comentario' => 'nullable|string'
        ]);

        try {

        } catch (\Throwable $th) {
        }
        if ($actividad = ActividadRegistrada::findOrFail($request->actividad)) {
            if ($actividad->rubricaEvaluacion->estatus) {
                switch ($request->evaluacion) {
                    case '1':
                        $expediente = $actividad->expediente;

                        /* Mensaje cuando no se comenta */
                        if ($request->comentario == null)
                            $request->comentario = 'Actividad validada por proyecto docencia';
                        
                        /* Marcar como credito valido */
                        $actividad->update([
                            'estatus' => '5',
                            'comentario' => $request->comentario
                        ]);

                        /* Calcular el nuevo numero de creditos */
                        $nuevosCreditos = $expediente->creditos + $actividad->creditoComplementario->valor;
                        
                        /* Calcular el nuevo promedio de rubricas */
                        $actividadesValidas = ActividadRegistrada::where('estatus', '5')->with('rubricaEvaluacion')->get();
                        $nuevoPromedio = 0;
                        for ($i=0; $i < count($actividadesValidas); $i++) { 
                            $nuevoPromedio += $actividadesValidas[$i]->rubricaEvaluacion->valor;
                        }
                        $nuevoPromedio = round(floatval($nuevoPromedio/$i), 2);

                        
                        /* Actualizar el expediente del alumno */
                        $expediente->creditos = $nuevosCreditos;
                        $expediente->promedio_rubricas = $nuevoPromedio;
                        $expediente->save();

                        return redirect()->back()->with('mensaje', 'La actividad complementaria se validó correctamente; Se sumaron los créditos y promediaron las rubricas');
                        break;
                    case '2':
                        /* Mensaje cuando no se comenta */
                        if ($request->comentario == null)
                            $request->comentario = 'Actividad rechazada por proyecto docencia, revise la información, edite y renvié la actividad ';

                        $actividad->update([
                            'comentario' => $request->comentario,
                            'estatus' => '4',
                            'edicion' => '1'
                        ]);

                        return redirect()->back()->with('mensaje', 'La actividad complementaria se rechazó correctamente; Se regresó al alumno para correcciones');
                        break;
                    case '3':
                        $actividad->delete();
                        $actividad->rubricaEvaluacion->delete();
                        return redirect()->back()->with('mensaje', 'La actividad complementaria se eliminó correctamente');
                        break;
                    default:
                        break;
                }
            }
            
        }
    }
    public function filtroPendientesCarrera($fecha_inicio, $fecha_fin, $carrera)
    {
        $expedientes = Expediente::select('expediente_creditos.*', 'alumno.*', 'carrera.nombre as nombre_carrera')
            ->selectRaw('COUNT(*) AS numero_act')
            ->join('alumno', 'alumno.no_de_control', 'expediente_creditos.no_de_control')
            ->join('carrera', 'carrera.id', 'alumno.id_carrera')
            ->join('proyecto_docencia', 'proyecto_docencia.id_departamento', 'carrera.id_departamento')
            ->join('actividades_registradas', 'actividades_registradas.no_de_control', 'alumno.no_de_control')
            ->where('actividades_registradas.estatus', '3')
            ->where('proyecto_docencia.id', Auth::user()->proyectoDocencia->id)
            ->where('alumno.id_carrera', $carrera)
            ->where('actividades_registradas.updated_at', '>=', $fecha_inicio." 00:00:01")
            ->where('actividades_registradas.updated_at', '<=', $fecha_fin." 23:59:59")
            ->orderBy('expediente_creditos.updated_at', 'desc')
            ->groupBy('expediente_creditos.no_de_control')
            ->groupBy('alumno.no_de_control')
            ->groupBy('carrera.nombre')
            ->get();
        $data = array('fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin, 'carrera' => $carrera);
        if (!empty($expedientes)) {
            foreach ($expedientes as $expediente) {
                /* Buscar si el expediente encontrado es de uno de su departamento */
                $expediente->fecha_apertura = strftime("%d/%m/%Y", strtotime($expediente->fecha_apertura));
                if ($expediente->fecha_cierre)
                    $expediente->fecha_cierre = strftime("%d/%m/%Y", strtotime($expediente->fecha_cierre));
                switch ($expediente->estatus) {
                    case true:
                        $expediente->datosEstatus = [
                            'nombre' => 'Abierto',
                            'color' => 'btn-primary'
                        ];
                        break;
                    case false:
                        $expediente->datosEstatus = [
                            'nombre' => 'Cerrado',
                            'color' => 'btn-danger'
                        ];
                        break;
                }
            }
            $docencia = Auth::user()->proyectoDocencia;
            if ($docencia->departamento->carreras->count() > 1) {
                $carreras = $docencia->departamento->carreras;
                return view('proyectoDocencia.buscarPendientes')->with(['expedientes' => $expedientes, 'carreras' => $carreras, 'data' => $data]);
            }
            return view('proyectoDocencia.buscarPendientes')->with(['expedientes' => $expedientes, 'data' => $data]);
        }
    }

    public function pendientesSemestre($semestre, $carrera = null)
    {
        if($carrera!=null){
            $expedientes = Expediente::select('expediente_creditos.*', 'alumno.*', 'carrera.nombre as nombre_carrera')
                    ->selectRaw('COUNT(*) AS numero_act')
                    ->join('alumno', 'alumno.no_de_control', 'expediente_creditos.no_de_control')
                    ->join('carrera', 'carrera.id', 'alumno.id_carrera')
                    ->join('proyecto_docencia', 'proyecto_docencia.id_departamento', 'carrera.id_departamento')
                    ->join('actividades_registradas', 'actividades_registradas.no_de_control', 'alumno.no_de_control')
                    ->where('actividades_registradas.estatus', '3')
                    ->where('proyecto_docencia.id', Auth::user()->proyectoDocencia->id)
                    ->where('alumno.semestre', $semestre)
                    ->where('alumno.id_carrera', $carrera)
                    ->orderBy('expediente_creditos.updated_at', 'desc')
                    ->groupBy('expediente_creditos.no_de_control')
                    ->groupBy('alumno.no_de_control')
                    ->groupBy('carrera.nombre')
                    ->get();
            $data = array('semestre' => $semestre, 'carrera' => $carrera);
        }
        else{
        $expedientes = Expediente::select('expediente_creditos.*', 'alumno.*', 'carrera.nombre as nombre_carrera')
            ->selectRaw('COUNT(*) AS numero_act')
            ->join('alumno', 'alumno.no_de_control', 'expediente_creditos.no_de_control')
            ->join('carrera', 'carrera.id', 'alumno.id_carrera')
            ->join('proyecto_docencia', 'proyecto_docencia.id_departamento', 'carrera.id_departamento')
            ->join('actividades_registradas', 'actividades_registradas.no_de_control', 'alumno.no_de_control')
            ->where('actividades_registradas.estatus', '3')
            ->where('proyecto_docencia.id', Auth::user()->proyectoDocencia->id)
            ->where('alumno.semestre', $semestre)
            ->orderBy('expediente_creditos.updated_at', 'desc')
            ->groupBy('expediente_creditos.no_de_control')
            ->groupBy('alumno.no_de_control')
            ->groupBy('carrera.nombre')
            ->get();
        $data = array('semestre' => $semestre);
        }
        if (!empty($expedientes)) {
            foreach ($expedientes as $expediente) {
                /* Buscar si el expediente encontrado es de uno de su departamento */
                $expediente->fecha_apertura = strftime("%d/%m/%Y", strtotime($expediente->fecha_apertura));
                if ($expediente->fecha_cierre)
                    $expediente->fecha_cierre = strftime("%d/%m/%Y", strtotime($expediente->fecha_cierre));
                switch ($expediente->estatus) {
                    case true:
                        $expediente->datosEstatus = [
                            'nombre' => 'Abierto',
                            'color' => 'btn-primary'
                        ];
                        break;
                    case false:
                        $expediente->datosEstatus = [
                            'nombre' => 'Cerrado',
                            'color' => 'btn-danger'
                        ];
                        break;
                }
            }
            $docencia = Auth::user()->proyectoDocencia;
            if ($docencia->departamento->carreras->count() > 1) {
                $carreras = $docencia->departamento->carreras;
                return view('proyectoDocencia.buscarPendientes')->with(['expedientes' => $expedientes, 'carreras' => $carreras, 'data' => $data]);
            }
            return view('proyectoDocencia.buscarPendientes')->with(['expedientes' => $expedientes, 'data' => $data]);
        }
    }
    public function pendientesCarrera($carrera)
    {
        $expedientes = Expediente::select('expediente_creditos.*', 'alumno.*', 'carrera.nombre as nombre_carrera')
            ->selectRaw('COUNT(*) AS numero_act')
            ->join('alumno', 'alumno.no_de_control', 'expediente_creditos.no_de_control')
            ->join('carrera', 'carrera.id', 'alumno.id_carrera')
            ->join('proyecto_docencia', 'proyecto_docencia.id_departamento', 'carrera.id_departamento')
            ->join('actividades_registradas', 'actividades_registradas.no_de_control', 'alumno.no_de_control')
            ->where('actividades_registradas.estatus', '3')
            ->where('proyecto_docencia.id', Auth::user()->proyectoDocencia->id)
            ->where('alumno.id_carrera', $carrera)
            ->orderBy('expediente_creditos.updated_at', 'desc')
            ->groupBy('expediente_creditos.no_de_control')
            ->groupBy('alumno.no_de_control')
            ->groupBy('carrera.nombre')
            ->get();
        $data = array('carrera' => $carrera);
        if (!empty($expedientes)) {
            foreach ($expedientes as $expediente) {
                /* Buscar si el expediente encontrado es de uno de su departamento */
                $expediente->fecha_apertura = strftime("%d/%m/%Y", strtotime($expediente->fecha_apertura));
                if ($expediente->fecha_cierre)
                    $expediente->fecha_cierre = strftime("%d/%m/%Y", strtotime($expediente->fecha_cierre));
                switch ($expediente->estatus) {
                    case true:
                        $expediente->datosEstatus = [
                            'nombre' => 'Abierto',
                            'color' => 'btn-primary'
                        ];
                        break;
                    case false:
                        $expediente->datosEstatus = [
                            'nombre' => 'Cerrado',
                            'color' => 'btn-danger'
                        ];
                        break;
                }
            }
            $docencia = Auth::user()->proyectoDocencia;
            if ($docencia->departamento->carreras->count() > 1) {
                $carreras = $docencia->departamento->carreras;
                return view('proyectoDocencia.buscarPendientes')->with(['expedientes' => $expedientes, 'carreras' => $carreras, 'data' => $data]);
            }
            return view('proyectoDocencia.buscarPendientes')->with(['expedientes' => $expedientes, 'data' => $data]);
        }
    }
    /* Cerrar expediente y subir constancia de liberacion */
    public function cerrarExpediente(Request $request) {
        $this->validate(request(), [
            'numeroControl' => 'required',
            'urlConstancia' => 'required|url'
        ]);
        
        /* Si tiene un expediente, este esta abierto y tienen mas de 5 creditos  */
        if ($expediente = Expediente::findOrFail($request->numeroControl)) {
            if ($expediente->estatus && $expediente->creditos >= 5) {
                /* Borramnos las actividades que no sean validas */
                foreach ($expediente->actividadesRegistradas as $actividad) {
                    if ($actividad->estatus != 5) {
                        $actividad->delete();
                        $actividad->rubricaEvaluacion->delete();
                    }
                }

                /* Enlazar la url de la constancia al expediente y actualizar estatus y fecha de cierre */
                $expediente->url_constancia_liberacion =  $request->urlConstancia;
                $expediente->fecha_cierre = date('Y-m-d');
                $expediente->estatus = false;
                $expediente->save();

                return redirect()->back()->with('mensaje', 'El expediente del alumno se cerró correctamente');
            }
        }
    }
}
