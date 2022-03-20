@extends('layouts.docencia')

@section('contenido')
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">BUSCAR EXPEDIENTES PENDIENTES</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <h5 class="text-muted"> <strong>Filtros de búsqueda:</strong></h5>
                        @php
                        if (Auth::user()->proyectoDocencia->departamento->carreras->count() > 1) {
                        $car=true;
                        } else $car=false;

                        @endphp
                        <form action="{{ route('docencia.pendientes.buscar') }}" method="post" id="form-buscar-carrera">
                            @csrf
                            @if($car)
                            <div class="col-sm-3">
                                <div class="form-group label-floating">
                                    <p>Carrera:</p>
                                    <select name="id_carrera" id="carrera" class="form-control">
                                        <option value="0" selected disabled>Seleccione una opción</option>
                                        @foreach($carreras as $carrera)
                                        <option value="{{$carrera->id}}" {{ isset($data['carrera']) ? $data['carrera']==$carrera->id ? 'selected="selected"' : '' : ''}}>{{$carrera->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="{{ $car==true ? 'col-sm-3' : 'col-sm-4' }}">
                                <div class="form-group label-floating">
                                    <p>Semestre:</p>
                                    <select name="semestre" id="semestre" class="form-control">
                                        <option value="0" selected disabled>Seleccione una opción</option>
                                        @for ($i=1; $i<13; $i++) <option value="{{$i}}" {{ isset($data['semestre']) ? $data['semestre']==$i ? 'selected="selected"' : '' : ''}}>{{$i}}°</option>
                                            @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="{{ $car==true ? 'col-sm-3' : 'col-sm-4' }}">
                                <div class="form-group label-floating">
                                    <p>Fecha Inicio:</p>
                                    <input type="date" name="inicio" id="inicio" class="form-control" onchange="cambiar_fin()" {{ isset($data['fecha_inicio']) ? "value=".$data['fecha_inicio'] : '' }}>
                                </div>
                            </div>
                            <div class="{{ $car==true ? 'col-sm-3' : 'col-sm-4' }}">
                                <div class="form-group label-floating">
                                    <p>Fecha Fin:</p>
                                    <input type="date" name="fin" id="fin" class="form-control" {{ isset($data['fecha_fin']) ? "value=".$data['fecha_fin'] : '' }}>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <hr class="bg-success mb-2">
                        <h5 class="text-muted"> <strong>Estatus:</strong></h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <h5 class="col-sm-3 text-muted">Abierto: <i class="btn btn-success fas fa-file-alt fa-2x" title="Abierto"></i></h5>
                                <h5 class="col-sm-3 text-muted">Cerrado: <i class="btn btn-danger fas fa-file-alt fa-2x" title="Cerrado"></i></h5>
                            </div>
                            <div class="col-sm-6 align-self-end">
                                <h5 class="text-muted text-right">Descargar CSV:
                                    <!-- Condiciones para mandar a descargar el archivo csv dependiendo de los filtros -->
                                    @if(empty($data))
                                    <a href="{{ route('docencia.csv.pendientes')}}" class="btn btn-info fas fa-file-csv fa-2x"></a>
                                    @else
                                    @php //Casos para filtrar generación de csv

                                    $carrera=isset($data['carrera']) ? $data['carrera'] : ''; //Var carrera
                                    $semestre=isset($data['semestre']) ? $data['semestre'] : ''; //Var semestre
                                    $inicio=isset($data['fecha_inicio']) ? $data['fecha_inicio'] : ''; //Var inicio
                                    $fin=isset($data['fecha_fin']) ? $data['fecha_fin'] : ''; //Var fin

                                    //Caso donde exista una carrera para filtrar
                                    if(!empty($data['carrera'])){
                                        if(empty($data['semestre'])){ //No semestre
                                            if(empty($data['fecha_inicio']) || empty($data['fecha_fin'])){ //No semestre, no fechas
                                                echo "<a href=".route('docencia.csv.pendientes.carrera', ['carrera' => $carrera])." class=\"btn btn-info fas fa-file-csv fa-2x\"></a>";
                                            } //No semestre
                                            else{
                                                echo "<a href=".route('docencia.csv.pendientes.filtro.carrera', ['inicio' => $inicio, 'fin' => $fin, 'carrera'=> $carrera])." class=\"btn btn-info fas fa-file-csv fa-2x\"></a>";
                                            }
                                        }
                                        else if(empty($data['fecha_inicio']) || empty($data['fecha_fin'])){ // No fechas
                                            echo "<a href=".route('docencia.csv.pendientes.semestre', ['semestre' => $semestre, 'carrera'=> $carrera])." class=\"btn btn-info fas fa-file-csv fa-2x\"></a>";
                                        }
                                        else{
                                            echo "<a href=".route('docencia.csv.pendientes.filtro', ['inicio' => $inicio, 'fin' => $fin, 'semestre' => $semestre, 'carrera'=> $carrera])." class=\"btn btn-info fas fa-file-csv fa-2x\"></a>";

                                        }
                                    }
                                    //Caso donde no existe una carrera de filtro
                                    else if(!empty($data['fecha_inicio']) || !empty($data['fecha_fin'])){ //No carrera, no fechas
                                            if(empty($data['semestre'])){
                                                echo "<a href=".route('docencia.csv.pendientes.filtro', ['inicio' => $inicio, 'fin' => $fin])." class=\"btn btn-info fas fa-file-csv fa-2x\"></a>";
                                            }
                                            else{
                                                echo "<a href=".route('docencia.csv.pendientes.filtro', ['inicio' => $inicio, 'fin' => $fin, 'semestre' => $semestre])." class=\"btn btn-info fas fa-file-csv fa-2x\"></a>";

                                            }
                                    }
                                    else{
                                        echo "<a href=".route('docencia.csv.pendientes.semestre', ['semestre' => $semestre])." class=\"btn btn-info fas fa-file-csv fa-2x\"></a>";
                                    }                 
                                    @endphp                                    

                                    @endif
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                @if(empty($data))
                <a href="{{route ('inicio.docencia')}}" class="btn btn-default btn-raised m-1">Atrás</a>
                @else
                <a href="{{route ('docencia.buscar.pendientes')}}" class="btn btn-default btn-raised m-1">Cancelar</a>
                @endif
                <button class="btn btn-primary btn-raised" form="form-buscar-carrera" type="submit" title="Buscar los expedientes de una carrera" id="buscar">
                    <i class="fas fa-search"></i>&nbsp;&nbsp;&nbsp;Buscar
                </button>
            </div>
        </div>
    </div>
</div>

<br>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="table-responsive">
                <table class="table table-bordered table-striped default">
                    <thead>
                        <tr>
                            <th colspan="8">ACTIVIDADES COMPLEMENTARIAS REGISTRADAS</td>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>No. de control</th>
                            <th>Nombre del Alumno</th>
                            <th>Semestre</th>
                            <th>Carrera</th>
                            <th>No. de Act. a Evaluar</th>
                            <th>Ultima Fecha</th>
                            <th>Expediente</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach($expedientes as $expediente)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$expediente->no_de_control}}</td>
                            <td>{{$expediente->alumno->nombre}} {{$expediente->alumno->apellido_paterno}} {{$expediente->alumno->apellido_materno ? $expediente->alumno->apellido_materno : ''}}</td>
                            <td>{{$expediente->alumno->semestre}}°</td>
                            <td>{{$expediente->nombre_carrera}}</td>
                            <td>{{$expediente->numero_act}}</td>
                            <td>{{$expediente->ultimaActividad[0]->updated_at}}</td>
                            <td><a href="{{ route('docencia.expediente.alumno', ['numeroControl' => $expediente->no_de_control]) }}"><button class="btn {{$expediente->datosEstatus['color']}} fas fa-file-alt fa-lg" title="{{$expediente->datosEstatus['nombre']}}"></button></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(!count($expedientes)>0)
            <br>
            <h4 class="text-center text-muted">No se tienen registros de expedientes</h4>
            <br>
            @endif
        </div>
    </div>
</div>


<script>
    var f = new Date();
    var actual = (f.getFullYear() + "-" + f.getMonth() + 1 + "-" + f.getDate());
    document.getElementById("inicio").max = actual;
    document.getElementById("fin").max = actual;
</script>
<script>
    function cambiar_fin() {
        var inicio = document.getElementById("inicio").value;
        document.getElementById("fin").min = inicio;
    }
</script>

@endsection

@section('errores')
@if ($errors->any())
@foreach ($errors->all() as $error)
<script>
    new PNotify({
        title: 'Error',
        text: '{{ $error }}',
        type: 'error'
    });
</script>
@endforeach
@endif
@endsection