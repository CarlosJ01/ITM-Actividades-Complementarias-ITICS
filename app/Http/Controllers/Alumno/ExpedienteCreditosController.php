<?php

namespace App\Http\Controllers\Alumno;

use App\Models\ExpedienteCreditos\Expediente;
use App\Models\SGE\Periodo;
use App\Models\CreditosComplementarios\CreditoComplementario;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SGE\Carrera;
use Auth;
use Validator;
use Storage;

class ExpedienteCreditosController extends Controller {
    /* Vistas */
    /* Expediente del alumno */
    public function expediente() {
        $alumno = Auth::user()->alumno;
        if ($alumno->expedienteCreditos) {
            $alumno->expedienteCreditos->actividadesRegistradas;
            $expediente = $alumno->expedienteCreditos;
            $expediente->fecha_apertura = strftime("%d/%m/%Y", strtotime($alumno->expedienteCreditos->fecha_apertura));
            if ($expediente->fecha_cierre)
                $expediente->fecha_cierre = strftime("%d/%m/%Y", strtotime($alumno->expedienteCreditos->fecha_cierre));
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
            $numero = 1;
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
                /* Condicion para creditos que son subcreditos de otros */
                if (isset(explode(".", $actividad->creditoComplementario->numero)[1])) {
                    /* Añade la descripcion del credito padre al pirncipio del hijo */
                    $actividad->creditoComplementario->descripcion = 
                        CreditoComplementario::where([
                            ['numero', intval($actividad->creditoComplementario->numero)], 
                            ['id_departamento', $actividad->creditoComplementario->id_departamento]
                        ])->first()->descripcion.'; '.$actividad->creditoComplementario->descripcion;
                }
                $actividad->numeroCredito = $numero++;
            }
            return view('alumno.expediente', compact('expediente'));
        } else {
            return view('alumno.sinExpediente');
        }
    }

    /* Acciones */
    /* Abrir un expediente */
    public function abrirExpediente() {
        try {
            Expediente::create([
                'no_de_control' => Auth::user()->alumno->no_de_control,
                'fecha_apertura' => date('Y-m-d'),
                'id_periodo' => Periodo::where('activo', 'true')->first()->id
            ]);
            return redirect()->route('alumno.expediente')->with('mensaje', 'Su expediente de créditos complementarios fue abierto exitosamente');
        } catch (\Throwable $th) {
        }
    
    }
    /* Buscar el expediente de un alumno */
    public function buscarExpediente(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'numeroControl' => 'required'
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors()->all())->withInput();
            }
            /* Buscar un expediente con el numero de control */
            if ($expediente = Expediente::where('no_de_control', $request->numeroControl)->first()) {
                /* Buscar si el expediente encontrado es de uno de su departamento */
                if (Auth::user()->proyectoDocencia->id_departamento == $expediente->alumno->carrera->id_departamento) {
                    return redirect()->route('docencia.expediente.alumno', ['numeroControl' => $request->numeroControl]);
                }
                return redirect()->back()->withErrors(['error' => 'El alumno con el numero de control '.$request->numeroControl.' no pertenece a tu departamento'])->withInput();
            } else {
                return redirect()->back()->withErrors(['error' => 'No se encontró un expediente de créditos complementarios con el número de control '.$request->numeroControl])->withInput();
            }
        } catch (\Throwable $th) {
        }
    }

    /* Buscar los expedientes de una carrera */
    public function buscarCarrera(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'carrera' => 'required'
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors()->all())->withInput();
            }
            if ($expediente = Expediente::
                        join('alumno', 'alumno.no_de_control', 'expediente_creditos.no_de_control')
                        ->join('carrera', 'carrera.id', 'alumno.id_carrera')
                        ->join('proyecto_docencia', 'proyecto_docencia.id_departamento', 'carrera.id_departamento')
                        ->where('carrera.id', $request->carrera)
                        ->where('proyecto_docencia.id', Auth::user()->proyectoDocencia->id)
                        ->get()
                ) {
                return redirect()->route('docencia.expediente.carrera', ['carrera' => $request->carrera]);
            }
            $carrera=Carrera::findOrFail($request->carrera);
            return redirect()->back()->withErrors(['error' => 'La carrera de '.$carrera->nombre.' no le pertenece al Jefe de Docencia'])->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'No se encontró la carrera'])->withInput();
        }
    }
    
    /* Buscar los expedientes con status */
    public function buscarExpedientes(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'estatus' => 'required'
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors()->all())->withInput();
            }
            if ($request->estatus==0 || $request->estatus==1){
                return redirect()->route('docencia.expedientes', ['estatus' => $request->estatus]);
            }
            return redirect()->back()->withErrors(['error' => 'La opción previamente marcada no existe'])->withInput();       
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'No se encontró la opción marcada'])->withInput();
        }
    }

    /* Buscar los expedientes pendientes mediante un filtro de busqueda */
    public function buscarPendientes(Request $request) {
        try {
            $newRequest=$request;
            if($newRequest->inicio==null){
                $request->replace($newRequest->except(['inicio']));
            }
            if($request->fin==null){
                $request->replace($newRequest->except(['fin']));
            }
            if(empty($request->except('_token'))){
                return redirect()->back();
            }
            else{
                //Caso: Si viene fecha de fin y no de inicio
                if(empty($request->inicio) && !empty($request->fin)){
                    return redirect()->back()->withErrors(['error' => 'Se deben especificar ambas fechas'])->withInput();;
                }
                //Caso: Si existe fecha de inicio y no de fin, se instancia la fecha de fin con la de hoy
                if(!empty($request->inicio) && empty($request->fin)){
                    date_default_timezone_set('America/Mexico_City');
                    $request->fin=date('Y-m-d');
                }
                //Caso donde exista una carrera para filtrar
                if((!empty($request->id_carrera))){
                    //Si no existe semestre como parámetro
                    if((empty($request->semestre))){ //No semestre
                        if(empty($request->inicio) || empty($request->fin)){ //No semestre, no fechas - si carrera
                            return redirect()->route('docencia.pendientes.carrera', ['carrera'=> $request->id_carrera]); 
                        } //No semestre - si carrera
                        else{
                            return redirect()->route('docencia.pendientes.filtro.carrera', ['inicio' => $request->inicio, 'fin' => $request->fin, 'carrera'=> $request->id_carrera]); 
                        }
                    }
                    else if(empty($request->inicio) || empty($request->fin)){ // No fechas, - si carrera
                        return redirect()->route('docencia.pendientes.semestre', ['semestre' => $request->semestre, 'carrera'=> $request->id_carrera]);
                    } 
                    else{ //si carrera, fechas y semestre
                        return redirect()->route('docencia.pendientes.filtro', ['inicio' => $request->inicio, 'fin' => $request->fin, 'semestre' => $request->semestre, 'carrera'=> $request->id_carrera]);
                    }
                }
                //Caso donde no existe una carrera de filtro
                if((empty($request->semestre))){ //Solo fechas
                    return redirect()->route('docencia.pendientes.filtro', ['inicio' => $request->inicio, 'fin' => $request->fin]);
                }
                if(empty($request->inicio) || empty($request->fin)){ //No carrera, no fechas
                    return redirect()->route('docencia.pendientes.semestre', ['semestre' => $request->semestre]);
                }
                return redirect()->route('docencia.pendientes.filtro', ['inicio' => $request->inicio, 'fin' => $request->fin, 'semestre' =>$request->semestre]);
        }
                        
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Ha ocurrido un error'])->withInput();
        }
    }
}
