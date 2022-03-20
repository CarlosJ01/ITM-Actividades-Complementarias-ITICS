<?php

namespace App\Http\Controllers\ResponsableActividad;

use App\Models\SGE\ResponsableActividadComplementaria;
use App\Models\CreditosComplementarios\CreditoComplementario;
use App\Models\CreditosComplementarios\RubricaEvaluacion;
use App\Models\ExpedienteCreditos\ActividadRegistrada;
use App\Models\SGE\Alumno;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;

class ResponsableActividadController extends Controller{
    /* Vistas */
    public function inicio(){
        $responsable = Auth::user()->responsableActividad;
        return view('responsableActividad.inicio', compact('responsable'));
    }
    /* Mostrar a todos los alumnos a evaluar */
    public function showRubricasAlumno(){
        $responsable = Auth::user()->responsableActividad;

        $alumnos=DB::table('alumno')
                    ->select('alumno.no_de_control', 'alumno.nombre', 'alumno.apellido_paterno', 'alumno.apellido_materno', 'alumno.semestre', 'carrera.nombre as nombre_carrera')
                    ->selectRaw('COUNT(*) AS numero_creditos')
                    ->join('carrera', 'carrera.id', 'alumno.id_carrera')
                    ->join('actividades_registradas', 'actividades_registradas.no_de_control', 'alumno.no_de_control')
                    ->join('rubrica_evaluacion_credito', 'actividades_registradas.id_rubrica_evaluacion_credito', 'rubrica_evaluacion_credito.id')
                    ->where('rubrica_evaluacion_credito.id_responsable', $responsable->id)
                    ->where('actividades_registradas.estatus', '1')
                    ->where('rubrica_evaluacion_credito.estatus', '0')
                    ->groupBy('alumno.no_de_control', 'carrera.nombre')
                    ->orderBy('alumno.no_de_control')
                    ->get();
        return view('responsableActividad.alumnos.index')->with('alumnos', $alumnos);
    }
    /* Indice de las actividades a evaluar */
    public function indexActividades() {
        try {
            $responsable = Auth::user()->responsableActividad;
            /* Actividades a evaluar por responsable */
            $actividades =  DB::table('responsable_actividad_complementaria')
                            ->select('credito_complementario.id', 'credito_complementario.numero', 'credito_complementario.descripcion', 'credito_complementario.valor', 'credito_complementario.id_departamento')
                            ->selectRaw('COUNT(*) AS numero_alumnos')
                            ->join('rubrica_evaluacion_credito', 'responsable_actividad_complementaria.id', '=', 'rubrica_evaluacion_credito.id_responsable')
                            ->join('actividades_registradas', 'rubrica_evaluacion_credito.id', '=', 'actividades_registradas.id_rubrica_evaluacion_credito')
                            ->join('credito_complementario', 'actividades_registradas.id_credito_complementario', '=', 'credito_complementario.id')
                            ->where('responsable_actividad_complementaria.id', '=', $responsable->id)
                            ->where('actividades_registradas.estatus', '=', '1')
                            ->where('rubrica_evaluacion_credito.estatus', '=','0')
                            ->groupBy('credito_complementario.id')
                            ->orderBy('credito_complementario.descripcion')
                            ->get();
            /* Formato a alas actividades */
            foreach ($actividades as $actividad) {
                if (isset(explode(".", $actividad->numero)[1])) {
                    $actividad->descripcion = 
                        CreditoComplementario::where([
                            ['numero', intval($actividad->numero)], 
                            ['id_departamento', $actividad->id_departamento]
                        ])->first()->descripcion.'; '.$actividad->descripcion;
                }
            }
            return view('responsableActividad.actividades.index')->with('actividades', $actividades);
        } catch (\Throwable $th) {
        }
    }
    /* Informacion del alumno a evaluar */
    public function showAlumno($control){
        try {
            $responsable = Auth::user()->responsableActividad;
            $alumno=Alumno::findOrFail($control);
            $actividades =  DB::table('responsable_actividad_complementaria')
                        ->select('actividades_registradas.id AS idActividad', 'credito_complementario.numero', 'credito_complementario.descripcion', 'credito_complementario.valor', 'credito_complementario.id_departamento',
                                 'actividades_registradas.fecha_inicio', 'actividades_registradas.fecha_fin', 
                                'actividades_registradas.enlace_evidencia', 'actividades_registradas.updated_at', 'actividades_registradas.comentario',
                                'rubrica_evaluacion_credito.id AS idRubrica', 'periodo.nombre as periodo')
                        ->join('rubrica_evaluacion_credito', 'responsable_actividad_complementaria.id', '=', 'rubrica_evaluacion_credito.id_responsable')
                        ->join('actividades_registradas', 'rubrica_evaluacion_credito.id', '=', 'actividades_registradas.id_rubrica_evaluacion_credito')
                        ->join('credito_complementario', 'credito_complementario.id', 'actividades_registradas.id_credito_complementario')
                        ->join('alumno', 'actividades_registradas.no_de_control', '=', 'alumno.no_de_control')
                        ->join('periodo', 'periodo.id', 'actividades_registradas.id_periodo')
                        ->where('responsable_actividad_complementaria.id', '=', $responsable->id)
                        ->where('actividades_registradas.estatus', '=', '1')
                        ->where('rubrica_evaluacion_credito.estatus', '=','0')
                        ->where('alumno.no_de_control', $control)
                        ->orderBy('actividades_registradas.updated_at')
                        ->get();
            if (count($actividades) == 0) {
                if (session('mensaje') == '') {
                    return redirect()->route('responsable.rubricas-alumno');
                }
                return redirect()->route('responsable.rubricas-alumno')->with('mensaje', session('mensaje'));
            }

            /* Formato a las fechas */
            foreach ($actividades as $actividad) {
                $actividad->fecha_inicio = strftime("%d/%m/%Y", strtotime($actividad->fecha_inicio));
                $actividad->fecha_fin = strftime("%d/%m/%Y", strtotime($actividad->fecha_fin));
                $actividad->updated_at = strftime("%d/%m/%Y %H:%M", strtotime($actividad->updated_at));
                /* Formato a la actividad */
                if (isset(explode(".", $actividad->numero)[1])) {
                    $actividad->descripcion = 
                        CreditoComplementario::where([
                            ['numero', intval($actividad->numero)], 
                            ['id_departamento', $actividad->id_departamento]
                        ])->first()->descripcion.'; '.$actividad->descripcion;
                }
            }
            return view('responsableActividad.alumnos.show')->with(['actividades' => $actividades, 'alumno' => $alumno]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /* Calificar rubrica de un alumno */
    public function calificarRubrica(Request $request) {
        $this->validate(request(), [
            'rubrica' => 'required|integer',
            'criterio_1' => 'required|integer',
            'criterio_2' => 'required|integer',
            'criterio_3' => 'required|integer',
            'criterio_4' => 'required|integer',
            'criterio_5' => 'required|integer',
            'criterio_6' => 'required|integer',
            'criterio_7' => 'required|integer',
            'observaciones' => 'nullable|string',
            'valor' => 'required|numeric'
        ]);
        try {
            //code...
        if ($rubrica = RubricaEvaluacion::findOrFail($request->rubrica)) {
            if (! $rubrica->estatus) {
                $responsable = Auth::user()->responsableActividad;
                if ($rubrica->id_responsable == $responsable->id) {
                    $actividad = $rubrica->actividadRegistrada;
                    if ($actividad->estatus == '1') {
                        $rubrica->update([
                            'criterio_1' => $request->criterio_1,
                            'criterio_2' => $request->criterio_2,
                            'criterio_3' => $request->criterio_3,
                            'criterio_4' => $request->criterio_4,
                            'criterio_5' => $request->criterio_5,
                            'criterio_6' => $request->criterio_6,
                            'criterio_7' => $request->criterio_7,
                            'observaciones' => $request->observaciones,
                            'valor' => $request->valor,
                            'estatus' => True
                        ]);
                        $actividad->estatus = '3';
                        $actividad->comentario = 'Enviado para ser revisado por proyecto docencia de tu departamento';
                        $actividad->save();
                        
                        //Returnar a misma vista
                        $control=$request['no_de_control'];
                        $alumno=Alumno::findOrFail($control);
                        $actividades =  DB::table('responsable_actividad_complementaria')
                                    ->select('actividades_registradas.id AS idActividad', 'credito_complementario.numero', 'credito_complementario.descripcion', 'credito_complementario.id_departamento',
                                            'actividades_registradas.fecha_inicio', 'actividades_registradas.fecha_fin', 
                                            'actividades_registradas.enlace_evidencia', 'actividades_registradas.updated_at', 'actividades_registradas.comentario',
                                            'rubrica_evaluacion_credito.id AS idRubrica', 'periodo.nombre as periodo')
                                    ->join('rubrica_evaluacion_credito', 'responsable_actividad_complementaria.id', '=', 'rubrica_evaluacion_credito.id_responsable')
                                    ->join('actividades_registradas', 'rubrica_evaluacion_credito.id', '=', 'actividades_registradas.id_rubrica_evaluacion_credito')
                                    ->join('credito_complementario', 'credito_complementario.id', 'actividades_registradas.id_credito_complementario')
                                    ->join('alumno', 'actividades_registradas.no_de_control', '=', 'alumno.no_de_control')
                                    ->join('periodo', 'periodo.id', 'actividades_registradas.id_periodo')
                                    ->where('responsable_actividad_complementaria.id', '=', $responsable->id)
                                    ->where('actividades_registradas.estatus', '=', '1')
                                    ->where('rubrica_evaluacion_credito.estatus', '=','0')
                                    ->where('alumno.no_de_control', $control)
                                    ->orderBy('actividades_registradas.updated_at')
                                    ->get();
                        if (count($actividades) == 0) {
                            if (session('mensaje') == '') {
                                return redirect()->route('responsable.rubricas-alumno')->with('mensaje', 'Actividades complementarias del alumno han sido calificadas con éxito');
                            }
                            return redirect()->route('responsable.rubricas-alumno')->with('mensaje', session('mensaje'));
                        }

                        /* Formato a las fechas */
                        foreach ($actividades as $actividad) {
                            $actividad->fecha_inicio = strftime("%d/%m/%Y", strtotime($actividad->fecha_inicio));
                            $actividad->fecha_fin = strftime("%d/%m/%Y", strtotime($actividad->fecha_fin));
                            $actividad->updated_at = strftime("%d/%m/%Y %H:%M", strtotime($actividad->updated_at));
                            /* Formato a la actividad */
                            if (isset(explode(".", $actividad->numero)[1])) {
                                $actividad->descripcion = 
                                    CreditoComplementario::where([
                                        ['numero', intval($actividad->numero)], 
                                        ['id_departamento', $actividad->id_departamento]
                                    ])->first()->descripcion.'; '.$actividad->descripcion;
                            }
                        }            
                        return redirect()->route('responsable.alumno', ['alumno'=>$alumno->no_de_control])->with('mensaje', 'Actividad complementaria calificada correctamente')->with(['actividades' => $actividades, 'alumno' => $alumno]);
                    }
                }
            }
        }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /* Informacion de una actividad a evaluar */
    public function showActividad($credito) {
        try {
            /* Buscar la info del credito y el responsable */
            $responsable = Auth::user()->responsableActividad;
            $actividad = CreditoComplementario::findOrFail($credito);
            $actividad->departamento;
            $alumnos =  DB::table('responsable_actividad_complementaria')
                        ->select('actividades_registradas.id AS idActividad', 'alumno.no_de_control', 'alumno.nombre', 'alumno.apellido_paterno', 
                                'alumno.apellido_materno', 'actividades_registradas.fecha_inicio', 'actividades_registradas.fecha_fin', 
                                'actividades_registradas.enlace_evidencia', 'actividades_registradas.updated_at', 'actividades_registradas.comentario',
                                'rubrica_evaluacion_credito.id AS idRubrica')
                        ->join('rubrica_evaluacion_credito', 'responsable_actividad_complementaria.id', '=', 'rubrica_evaluacion_credito.id_responsable')
                        ->join('actividades_registradas', 'rubrica_evaluacion_credito.id', '=', 'actividades_registradas.id_rubrica_evaluacion_credito')
                        ->join('alumno', 'actividades_registradas.no_de_control', '=', 'alumno.no_de_control')
                        ->where('responsable_actividad_complementaria.id', '=', $responsable->id)
                        ->where('actividades_registradas.id_credito_complementario', '=', $actividad->id)
                        ->where('actividades_registradas.estatus', '=', '1')
                        ->where('rubrica_evaluacion_credito.estatus', '=','0')
                        ->orderBy('actividades_registradas.updated_at')
                        ->get();
            
            if (count($alumnos) == 0) {
                if (session('mensaje') == '') {
                    return redirect()->route('responsable.actividades');
                }
                return redirect()->route('responsable.actividades')->with('mensaje', session('mensaje'));
            }
            /* Formato a las fechas */
            foreach ($alumnos as $alumno) {
                $alumno->fecha_inicio = strftime("%d/%m/%Y", strtotime($alumno->fecha_inicio));
                $alumno->fecha_fin = strftime("%d/%m/%Y", strtotime($alumno->fecha_fin));
                $alumno->updated_at = strftime("%d/%m/%Y %H:%M", strtotime($alumno->updated_at));
            }
            /* Formato a la actividad */
            if (isset(explode(".", $actividad->numero)[1])) {
                $actividad->descripcion = 
                    CreditoComplementario::where([
                        ['numero', intval($actividad->numero)], 
                        ['id_departamento', $actividad->id_departamento]
                    ])->first()->descripcion.'; '.$actividad->descripcion;
            }

            return view('responsableActividad.actividades.show')->with('mensaje', 'Actividad complementaria calificada correctamente')->with(['actividad' => $actividad, 'alumnos' => $alumnos]);
        } catch (\Throwable $th) {
        }
    }
    
    /* Datos */
    /* Obtener los responsables por departamento */
    public function getResponsableDepartamento($idDepartamento) {
        try {
            if ($idDepartamento != 0) {
                $responsables = ResponsableActividadComplementaria::where('id_departamento', $idDepartamento)->orderBy('nombre')->get();
            } else {
                $responsables = ResponsableActividadComplementaria::all();
            }
            return response()->json(['responsables' => $responsables], 200);
        } catch (\Throwable $error) {
            return response()->json(['No es posible obtener los responsables de la actividad'], 400);
        }
    }

    /* Acciones */
    /* Rechazar actividad  */
    public function rechazarActividad(Request $request) {
        $this->validate(request(), [
            'actividad' => 'required|numeric',
            'comentario' => 'nullable|string'
        ]);

        if ($request->comentario == null) {
            $request->comentario = 'Actividad rechazada por el responsable de la actividad complementaria';
        }
        try {
            if ($actividad = ActividadRegistrada::findOrFail($request->actividad)) {
                $actividad->update([
                    'comentario' => $request->comentario,
                    'estatus' => '2',
                    'edicion' => '1',
                ]);
                
                return redirect()->back()->with('mensaje', 'Actividad complementaria rechazada correctamente');
            }    
        } catch (\Throwable $th) {
        }
    }
    /* Calificar una rubrica individual v1*/
    public function calificarRubricaV1(Request $request) {
        $this->validate(request(), [
            'rubrica' => 'required|integer',
            'criterio_1' => 'required|integer',
            'criterio_2' => 'required|integer',
            'criterio_3' => 'required|integer',
            'criterio_4' => 'required|integer',
            'criterio_5' => 'required|integer',
            'criterio_6' => 'required|integer',
            'criterio_7' => 'required|integer',
            'observaciones' => 'nullable|string',
            'valor' => 'required|numeric'
        ]);
        
        if ($rubrica = RubricaEvaluacion::findOrFail($request->rubrica)) {
            if (! $rubrica->estatus) {
                if ($rubrica->id_responsable == Auth::user()->responsableActividad->id) {
                    $actividad = $rubrica->actividadRegistrada;
                    if ($actividad->estatus == '1') {
                        $rubrica->update([
                            'criterio_1' => $request->criterio_1,
                            'criterio_2' => $request->criterio_2,
                            'criterio_3' => $request->criterio_3,
                            'criterio_4' => $request->criterio_4,
                            'criterio_5' => $request->criterio_5,
                            'criterio_6' => $request->criterio_6,
                            'criterio_7' => $request->criterio_7,
                            'observaciones' => $request->observaciones,
                            'valor' => $request->valor,
                            'estatus' => True
                        ]);
                        $actividad->estatus = '3';
                        $actividad->comentario = 'Enviado para ser revisado por proyecto docencia de tu departamento';
                        $actividad->save();

                        return redirect()->route('responsable.actividad', ['actividad'=>$actividad->id_credito_complementario])
                        ->with('mensaje', 'Rubrica de evaluación calificada correctamente');
                    }
                }
            }
        }
    }
    /* Calificar rubricas masivamente */
    public function calificarRubricasMasivamente(Request $request) {
        $this->validate(request(), [
            'actividad' => 'required|integer',
            'criterio_1' => 'required|integer',
            'criterio_2' => 'required|integer',
            'criterio_3' => 'required|integer',
            'criterio_4' => 'required|integer',
            'criterio_5' => 'required|integer',
            'criterio_6' => 'required|integer',
            'criterio_7' => 'required|integer',
            'observaciones' => 'nullable|string',
            'valor' => 'required|numeric'
        ]);
        /* Buscamos a los alumnos */
        $responsable = Auth::user()->responsableActividad;
        $credito = CreditoComplementario::findOrFail($request->actividad);
        $actividadRegistradas =  DB::table('responsable_actividad_complementaria')
                            ->select('actividades_registradas.id')
                            ->join('rubrica_evaluacion_credito', 'responsable_actividad_complementaria.id', '=', 'rubrica_evaluacion_credito.id_responsable')
                            ->join('actividades_registradas', 'rubrica_evaluacion_credito.id', '=', 'actividades_registradas.id_rubrica_evaluacion_credito')
                            ->where('responsable_actividad_complementaria.id', '=', $responsable->id)
                            ->where('actividades_registradas.id_credito_complementario', '=', $credito->id)
                            ->where('actividades_registradas.estatus', '=', '1')
                            ->where('rubrica_evaluacion_credito.estatus', '=','0')
                            ->get();
        
        /* Evaluamos todas las rubricas de los alumnos */
        foreach ($actividadRegistradas as $actividadRegistrada) {
            /* Actividad Registrada */
            $actividad = ActividadRegistrada::findOrFail($actividadRegistrada->id);
            $actividad->estatus = '3';
            $actividad->comentario = 'Enviado para ser revisado por proyecto docencia de tu departamento';
            $actividad->save();

            /* Rubrica */
            $actividad->rubricaEvaluacion->update([
                'criterio_1' => $request->criterio_1,
                'criterio_2' => $request->criterio_2,
                'criterio_3' => $request->criterio_3,
                'criterio_4' => $request->criterio_4,
                'criterio_5' => $request->criterio_5,
                'criterio_6' => $request->criterio_6,
                'criterio_7' => $request->criterio_7,
                'observaciones' => $request->observaciones,
                'valor' => $request->valor,
                'estatus' => True
            ]);
        }

        return redirect()->route('responsable.actividades')->with('mensaje', 'Todos los alumnos en la actividad complementaria, fueron evaluados correctamente  ');
    }
}
