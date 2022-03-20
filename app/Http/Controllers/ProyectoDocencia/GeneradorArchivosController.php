<?php

namespace App\Http\Controllers\ProyectoDocencia;

use App\Models\ExpedienteCreditos\Expediente;
use App\Models\SGE\Carrera;
use App\Models\ExpedienteCreditos\ActividadRegistrada;
use App\Models\CreditosComplementarios\CreditoComplementario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Response;

class GeneradorArchivosController extends Controller
{
    /* Generar y descargar la tabla de expedientes con filtro de carrera en CSV*/
    public function csvCarrera($id_carrera) {
        if ($expedientes = Expediente::select('expediente_creditos.*', 'alumno.*')
            ->join('alumno', 'alumno.no_de_control', 'expediente_creditos.no_de_control')
            ->join('carrera', 'carrera.id', 'alumno.id_carrera')
            ->join('proyecto_docencia', 'proyecto_docencia.id_departamento', 'carrera.id_departamento')
            ->where('carrera.id', $id_carrera)
            ->where('proyecto_docencia.id', Auth::user()->proyectoDocencia->id)
            ->orderBy('expediente_creditos.updated_at', 'desc')
            ->get()
        ) {

            $filename = "expedientes".Auth::user()->id.".csv";
            $file="expedientes.csv";
            $handle = fopen($filename, 'w+');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($handle, array('No. de Control', 'Nombre', 'Semestre', 'No. de Actividades', 'Estatus'));

            foreach ($expedientes as $expediente) {
                if ($expediente->estatus == 1) {
                    $expediente->estatus = "Abierto";
                } else {
                    $expediente->estatus = "Cerrado";
                }
                if ($expediente->apellido_materno) {
                    $expediente->nombre_alumno = $expediente->nombre . " " . $expediente->apellido_paterno . " " . $expediente->apellido_materno;
                } else {
                    $expediente->nombre_alumno = $expediente->nombre . " " . $expediente->apellido_paterno;
                }

                $expediente->numeroActividadesRegistradas = count($expediente->actividadesRegistradas);
                fputcsv($handle, array($expediente->no_de_control, $expediente->nombre_alumno, $expediente->semestre, $expediente->numeroActividadesRegistradas, $expediente->estatus));
            }
            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/csv',
            );

            return Response::download($filename, $file, $headers)->deleteFileAfterSend($shouldDelete = true);
        } else {
            return redirect()->back()->withErrors(['error' => 'No se ha podido generar el archivo para descargar'])->withInput();
        }
    }

    /* Generar y descargar la tabla de expedientes con filtro de estatus del expediente (abierto/cerrado) en CSV*/
    public function csvEstatus($estatus) {
        if ($expedientes = Expediente::select('expediente_creditos.*', 'alumno.*')
            ->join('alumno', 'alumno.no_de_control', 'expediente_creditos.no_de_control')
            ->join('carrera', 'carrera.id', 'alumno.id_carrera')
            ->join('proyecto_docencia', 'proyecto_docencia.id_departamento', 'carrera.id_departamento')
            ->where('proyecto_docencia.id', Auth::user()->proyectoDocencia->id)
            ->where('expediente_creditos.estatus', $estatus)
            ->orderBy('expediente_creditos.updated_at', 'desc')
            ->get()
        ) {
            /* Condicion para nombrar el archivo dependiendo del estatus */
            if($estatus==1){
                $filename = "expedientes-abiertos".Auth::user()->id.".csv";
                $file= "expedientes-abiertos.csv";
                
            }
            else{
                $filename = "expedientes-cerrados".Auth::user()->id.".csv";
                $file="expedientes-cerrados.csv";
            }

            $handle = fopen($filename, 'w+');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($handle, array('No. de Control', 'Nombre', 'Semestre', 'No. de Actividades', 'Promedio','Estatus'));

            foreach ($expedientes as $expediente) {
                if ($expediente->estatus == 1) {
                    $expediente->estatus = "Abierto";
                } else {
                    $expediente->estatus = "Cerrado";
                }
                if ($expediente->apellido_materno) {
                    $expediente->nombre_alumno = $expediente->nombre . " " . $expediente->apellido_paterno . " " . $expediente->apellido_materno;
                } else {
                    $expediente->nombre_alumno = $expediente->nombre . " " . $expediente->apellido_paterno;
                }

                $expediente->numeroActividadesRegistradas = count($expediente->actividadesRegistradas);
                fputcsv($handle, array($expediente->no_de_control, $expediente->nombre_alumno, $expediente->semestre, $expediente->numeroActividadesRegistradas, $expediente->promedio_rubricas, $expediente->estatus));
            }
            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/csv',
            );

            return Response::download($filename, $file, $headers)->deleteFileAfterSend($shouldDelete = true);
        } else {
            return redirect()->back()->withErrors(['error' => 'No se ha podido generar el archivo para descargar'])->withInput();
        }
    } 

    /* Generar y descargar la tabla de expedientes cerrados con su filtro en CSV*/
    public function csvExpedientesCerrados(Request $request) {
        /* Si no se enviaron los datos del filtro */
        if ($request->carrera == null && $request->semestre == null && $request->fechaInicio == null && $request->fechaFin == null) {
            return redirect()->back()->withErrors(['error' => 'Selecciona un filtro']);
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

            /* Generar el archivo CSV */
            $file='expedientes-cerrados'.Auth::user()->id.'.csv';
            $handle = fopen('expedientes-cerrados'.Auth::user()->id.'.csv', 'w+');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            $headers = array(
                'Content-Type' => 'text/csv',
            );
            fputcsv($handle, array('No. de Control', 'Nombre', 'Carrera', 'Semestre','Fecha de cierre', 'Promedio'));

            /* Llenar el archivo CSV */
            foreach ($expedientes as $expediente) {
                fputcsv($handle, array($expediente->no_de_control, 
                                        $expediente->alumno->apellido_paterno.' '.($expediente->alumno->apellido_materno ? $expediente->alumno->apellido_materno : '').' '.$expediente->alumno->nombre, 
                                        $expediente->alumno->carrera->nombre,
                                        $expediente->alumno->semestre, 
                                        $expediente->fecha_cierre,
                                        $expediente->promedio_rubricas));
            }
            fclose($handle);

            /* Descargar el archivo */
            return response()->download($file, 'expedientes-creditos-cerrados.csv', $headers)->deleteFileAfterSend($shouldDelete = true);
        }
    }
    /* Descargar la plantilla de la carta de liberacion de creditos complementarios en word */
    public function descargarPlantillaCreditos($numeroControl) {
        /* Buscar expediente, este abierto y tenga al menos 5 creditos */
        if ($expediente = Expediente::findOrFail($numeroControl)) {
            if ($expediente->estatus && $expediente->creditos >= 5) {
                /* Crear el documento de Office Word */
                try {
                    /* Informacion y formado del expediente y actividades complementarias */
                    $nombreCompleto = mb_strtoupper($expediente->alumno->nombre.' '.$expediente->alumno->apellido_paterno.' '.($expediente->alumno->apellido_materno ? $expediente->alumno->apellido_materno : ''), 'UTF-8');
                    $carrera = mb_strtoupper($expediente->alumno->carrera->nombre, 'UTF-8');
                    $numeroControl = $expediente->no_de_control;
                    $actividades = ActividadRegistrada::where('no_de_control', $numeroControl)->where('estatus', '5')->get();
                    foreach ($actividades as $actividad) {
                        $actividad->fecha_inicio = strftime("%d/%m/%Y", strtotime($actividad->fecha_inicio));
                        $actividad->fecha_fin = strftime("%d/%m/%Y", strtotime($actividad->fecha_fin));
                        if (isset(explode(".", $actividad->creditoComplementario->numero)[1])) {
                            $actividad->creditoComplementario->descripcion =
                                CreditoComplementario::where([
                                    ['numero', intval($actividad->creditoComplementario->numero)],
                                    ['id_departamento', $actividad->creditoComplementario->id_departamento]
                                ])->first()->descripcion . '; ' . $actividad->creditoComplementario->descripcion;
                        }
                    }

                    /* Abrir el archivo y darle los valores a la plantilla */
                    $plantilla = new \PhpOffice\PhpWord\TemplateProcessor(resource_path('templates/liberacion_creditos_complementarios.docx'));
                    $plantilla->setValue('nombre_completo', $nombreCompleto);
                    $plantilla->setValue('carrera', $carrera);
                    $plantilla->setValue('numeroControl', $numeroControl);
                    for ($i=0; $i < 5; $i++) {
                        if (isset($actividades[$i])) {
                            $plantilla->setValue('actividad_'.($i+1), $actividades[$i]->creditoComplementario->descripcion);
                            $plantilla->setValue('credito_'.($i+1), $actividades[$i]->creditoComplementario->valor);
                            $plantilla->setValue('fecha_'.($i+1), $actividades[$i]->fecha_inicio.' - '.$actividades[$i]->fecha_fin);
                        } else {
                            $plantilla->setValue('actividad_'.($i+1), '');
                            $plantilla->setValue('credito_'.($i+1), '');
                            $plantilla->setValue('fecha_'.($i+1), '');
                        }
                    }
                    $plantilla->setValue('califiacion', $expediente->promedio_rubricas);

                    /* Configuracion del archivo a descargar */
                    $archivo = tempnam(sys_get_temp_dir(),'PHPWord');
                    $plantilla->saveAs($archivo);
                    $header = [
                        "Content-Type: application/octet-stream",
                    ];

                    /* Descargar el archivo */
                    return response()->download($archivo, 'plantilla_liberacion_'.$numeroControl.'.docx', $header)->deleteFileAfterSend($shouldDelete = true);
                } catch (\PhpOffice\PhpWord\Exception\Exception $e) {
                    return back($e->getCode());
                }
            }
        }
    }

    /* --------------------------------- Generación CSV (DOCENCIA) Filtro de busqueda --------------------------- */

    /* Generar y descargar la tabla de todos los expedientes que estén pendientes */

    public function csvPendientes() {
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
            $filename = "expedientes-pendientes".Auth::user()->id.".csv";
            $file = "expedientes-pendientes.csv";
            $handle = fopen($filename, 'w+');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($handle, array('No. de Control', 'Nombre', 'Semestre', 'Carrera', 'No. de Actividades', 'Ult. Modificacion', 'Estatus'));
            foreach ($expedientes as $expediente) {
                if ($expediente->estatus == 1) {
                    $expediente->estatus = "Abierto";
                } else {
                    $expediente->estatus = "Cerrado";
                }
                if ($expediente->apellido_materno) {
                    $expediente->nombre_alumno = $expediente->nombre . " " . $expediente->apellido_paterno . " " . $expediente->apellido_materno;
                } else {
                    $expediente->nombre_alumno = $expediente->nombre . " " . $expediente->apellido_paterno;
                }
                $expediente->actualizacion = substr($expediente->ultimaActividad[0]->updated_at, 0, 10);

                fputcsv($handle, array($expediente->no_de_control, $expediente->nombre_alumno, $expediente->semestre, $expediente->nombre_carrera, $expediente->numero_act, $expediente->actualizacion, $expediente->estatus));
            }
            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/csv',
            );

            return Response::download($filename, $file, $headers)->deleteFileAfterSend($shouldDelete = true);
        } else {
            return redirect()->back()->withErrors(['error' => 'No se ha podido generar el archivo para descargar'])->withInput();
        }
    }

    /* Generar y descargar la tabla de expedientes pendientes con filtros de busqueda donde existen las fechas*/

    public function csvPendientesFiltro($fecha_inicio, $fecha_fin, $semestre = null, $carrera = null) {
        /* Modificacion de las variables para hacer la busqueda */
        $fecha_inicio=$fecha_inicio." 00:00:01";
        $fecha_fin=$fecha_fin." 23:59:59";
        /* Condición donde existe el semestre como parámetro */
        if ($semestre != null) { 
            /* Condición donde existe carrera como parámetro*/
            if ($carrera != null) { 
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
                    ->where('actividades_registradas.updated_at', '>=', $fecha_inicio)
                    ->where('actividades_registradas.updated_at', '<=', $fecha_fin)
                    ->orderBy('expediente_creditos.updated_at', 'desc')
                    ->groupBy('expediente_creditos.no_de_control')
                    ->groupBy('alumno.no_de_control')
                    ->groupBy('carrera.nombre')
                    ->get();
            } else {
                /* Condición donde no existe la carrera */
                $expedientes = Expediente::select('expediente_creditos.*', 'alumno.*', 'carrera.nombre as nombre_carrera')
                    ->selectRaw('COUNT(*) AS numero_act')
                    ->join('alumno', 'alumno.no_de_control', 'expediente_creditos.no_de_control')
                    ->join('carrera', 'carrera.id', 'alumno.id_carrera')
                    ->join('proyecto_docencia', 'proyecto_docencia.id_departamento', 'carrera.id_departamento')
                    ->join('actividades_registradas', 'actividades_registradas.no_de_control', 'alumno.no_de_control')
                    ->where('actividades_registradas.estatus', '3')
                    ->where('proyecto_docencia.id', Auth::user()->proyectoDocencia->id)
                    ->where('alumno.semestre', $semestre)
                    ->where('actividades_registradas.updated_at', '>=', $fecha_inicio)
                    ->where('actividades_registradas.updated_at', '<=', $fecha_fin)
                    ->orderBy('expediente_creditos.updated_at', 'desc')
                    ->groupBy('expediente_creditos.no_de_control')
                    ->groupBy('alumno.no_de_control')
                    ->groupBy('carrera.nombre')
                    ->get();
            }
        } else {
            /* Condición donde no existe el semestre como parámetro */
            $expedientes = Expediente::select('expediente_creditos.*', 'alumno.*', 'carrera.nombre as nombre_carrera')
                ->selectRaw('COUNT(*) AS numero_act')
                ->join('alumno', 'alumno.no_de_control', 'expediente_creditos.no_de_control')
                ->join('carrera', 'carrera.id', 'alumno.id_carrera')
                ->join('proyecto_docencia', 'proyecto_docencia.id_departamento', 'carrera.id_departamento')
                ->join('actividades_registradas', 'actividades_registradas.no_de_control', 'alumno.no_de_control')
                ->where('actividades_registradas.estatus', '3')
                ->where('proyecto_docencia.id', Auth::user()->proyectoDocencia->id)
                ->where('actividades_registradas.updated_at', '>=', $fecha_inicio)
                ->where('actividades_registradas.updated_at', '<=', $fecha_fin)
                ->orderBy('expediente_creditos.updated_at', 'desc')
                ->groupBy('expediente_creditos.no_de_control')
                ->groupBy('alumno.no_de_control')
                ->groupBy('carrera.nombre')
                ->get();
        }

        if (!empty($expedientes)) {
            
            $filename = "expedientes-pendientes".Auth::user()->id.".csv";
            $file = "expedientes-pendientes.csv";
            $handle = fopen($filename, 'w+');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($handle, array('No. de Control', 'Nombre', 'Semestre', 'Carrera', 'No. de Actividades', 'Ult. Modificacion', 'Estatus'));
            foreach ($expedientes as $expediente) {
                if ($expediente->estatus == 1) {
                    $expediente->estatus = "Abierto";
                } else {
                    $expediente->estatus = "Cerrado";
                }
                if ($expediente->apellido_materno) {
                    $expediente->nombre_alumno = $expediente->nombre . " " . $expediente->apellido_paterno . " " . $expediente->apellido_materno;
                } else {
                    $expediente->nombre_alumno = $expediente->nombre . " " . $expediente->apellido_paterno;
                }
                $expediente->actualizacion = substr($expediente->ultimaActividad[0]->updated_at, 0, 10);

                fputcsv($handle, array($expediente->no_de_control, $expediente->nombre_alumno, $expediente->semestre, $expediente->nombre_carrera, $expediente->numero_act, $expediente->actualizacion, $expediente->estatus));
            }
            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/csv',
            );

            return Response::download($filename, $file, $headers)->deleteFileAfterSend($shouldDelete = true);
        } else {
            return redirect()->back()->withErrors(['error' => 'No se ha podido generar el archivo para descargar'])->withInput();
        }
    }

    /* Generar y descargar la tabla de expedientes pendientes con filtros de busqueda con las fechas y carrera*/

    public function csvPendientesFiltroCarrera($fecha_inicio, $fecha_fin, $carrera) {
        /* Modificación de las variables para hacer la busqueda */
        $fecha_inicio=$fecha_inicio." 00:00:01";
        $fecha_fin=$fecha_fin." 23:59:59";
        
        $expedientes = Expediente::select('expediente_creditos.*', 'alumno.*', 'carrera.nombre as nombre_carrera')
            ->selectRaw('COUNT(*) AS numero_act')
            ->join('alumno', 'alumno.no_de_control', 'expediente_creditos.no_de_control')
            ->join('carrera', 'carrera.id', 'alumno.id_carrera')
            ->join('proyecto_docencia', 'proyecto_docencia.id_departamento', 'carrera.id_departamento')
            ->join('actividades_registradas', 'actividades_registradas.no_de_control', 'alumno.no_de_control')
            ->where('actividades_registradas.estatus', '3')
            ->where('proyecto_docencia.id', Auth::user()->proyectoDocencia->id)
            ->where('alumno.id_carrera', $carrera)
            ->where('actividades_registradas.updated_at', '>=', $fecha_inicio)
            ->where('actividades_registradas.updated_at', '<=', $fecha_fin)
            ->orderBy('expediente_creditos.updated_at', 'desc')
            ->groupBy('expediente_creditos.no_de_control')
            ->groupBy('alumno.no_de_control')
            ->groupBy('carrera.nombre')
            ->get();
        if (!empty($expedientes)) {
            $filename = "expedientes-pendientes".Auth::user()->id.".csv";
            $file = "expedientes-pendientes.csv";
            $handle = fopen($filename, 'w+');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($handle, array('No. de Control', 'Nombre', 'Semestre', 'Carrera', 'No. de Actividades', 'Ult. Modificacion', 'Estatus'));
            foreach ($expedientes as $expediente) {
                if ($expediente->estatus == 1) {
                    $expediente->estatus = "Abierto";
                } else {
                    $expediente->estatus = "Cerrado";
                }
                if ($expediente->apellido_materno) {
                    $expediente->nombre_alumno = $expediente->nombre . " " . $expediente->apellido_paterno . " " . $expediente->apellido_materno;
                } else {
                    $expediente->nombre_alumno = $expediente->nombre . " " . $expediente->apellido_paterno;
                }
                $expediente->actualizacion = substr($expediente->ultimaActividad[0]->updated_at, 0, 10);

                fputcsv($handle, array($expediente->no_de_control, $expediente->nombre_alumno, $expediente->semestre, $expediente->nombre_carrera, $expediente->numero_act, $expediente->actualizacion, $expediente->estatus));
            }
            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/csv',
            );

            return Response::download($filename, $file, $headers)->deleteFileAfterSend($shouldDelete = true);
        } else {
            return redirect()->back()->withErrors(['error' => 'No se ha podido generar el archivo para descargar'])->withInput();
        }
    }

    /* Generar y descargar la tabla de expedientes pendientes con filtros de busqueda donde existe el semestre*/

    public function csvPendientesSemestre($semestre, $carrera = null) {
        /* Condicion donde existe la carrera como parametro */
        if ($carrera != null) {
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
        } else {
            /* Condición donde no existe la carrera como parametro */
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
        }
        if (!empty($expedientes)) {
            $filename = "expedientes-pendientes".Auth::user()->id.".csv";
            $file = "expedientes-pendientes.csv";
            $handle = fopen($filename, 'w+');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($handle, array('No. de Control', 'Nombre', 'Semestre', 'Carrera', 'No. de Actividades', 'Ult. Modificacion', 'Estatus'));
            foreach ($expedientes as $expediente) {
                if ($expediente->estatus == 1) {
                    $expediente->estatus = "Abierto";
                } else {
                    $expediente->estatus = "Cerrado";
                }
                if ($expediente->apellido_materno) {
                    $expediente->nombre_alumno = $expediente->nombre . " " . $expediente->apellido_paterno . " " . $expediente->apellido_materno;
                } else {
                    $expediente->nombre_alumno = $expediente->nombre . " " . $expediente->apellido_paterno;
                }
                $expediente->actualizacion = substr($expediente->ultimaActividad[0]->updated_at, 0, 10);

                fputcsv($handle, array($expediente->no_de_control, $expediente->nombre_alumno, $expediente->semestre, $expediente->nombre_carrera, $expediente->numero_act, $expediente->actualizacion, $expediente->estatus));
            }
            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/csv',
            );

            return Response::download($filename, $file, $headers)->deleteFileAfterSend($shouldDelete = true);
        } else {
            return redirect()->back()->withErrors(['error' => 'No se ha podido generar el archivo para descargar'])->withInput();
        }
    }

    /* Generar y descargar la tabla de expedientes pendientes con filtro en una carrera en específica */

    public function csvPendientesCarrera($carrera) {
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

        if (!empty($expedientes)) {
            $filename = "expedientes-pendientes".Auth::user()->id.".csv";
            $file = "expedientes-pendientes.csv";
            $handle = fopen($filename, 'w+');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($handle, array('No. de Control', 'Nombre', 'Semestre', 'Carrera', 'No. de Actividades', 'Ult. Modificacion', 'Estatus'));
            foreach ($expedientes as $expediente) {
                if ($expediente->estatus == 1) {
                    $expediente->estatus = "Abierto";
                } else {
                    $expediente->estatus = "Cerrado";
                }
                if ($expediente->apellido_materno) {
                    $expediente->nombre_alumno = $expediente->nombre . " " . $expediente->apellido_paterno . " " . $expediente->apellido_materno;
                } else {
                    $expediente->nombre_alumno = $expediente->nombre . " " . $expediente->apellido_paterno;
                }
                $expediente->actualizacion = substr($expediente->ultimaActividad[0]->updated_at, 0, 10);

                fputcsv($handle, array($expediente->no_de_control, $expediente->nombre_alumno, $expediente->semestre, $expediente->nombre_carrera, $expediente->numero_act, $expediente->actualizacion, $expediente->estatus));
            }
            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/csv',
            );

            return Response::download($filename, $file, $headers)->deleteFileAfterSend($shouldDelete = true);
        } else {
            return redirect()->back()->withErrors(['error' => 'No se ha podido generar el archivo para descargar'])->withInput();
        }
    }
}
