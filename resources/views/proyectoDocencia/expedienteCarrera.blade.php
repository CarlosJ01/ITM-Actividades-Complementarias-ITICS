@extends('layouts.docencia')

@section('contenido')
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">EXPEDIENTES DE CREDITOS COMPLEMENTARIOS</h3>
            </div>
            <div class="panel-body">
            <h5 class="text-muted"> <strong>Estatus:</strong></h5>
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="col-sm-3 text-muted">Abierto: <i class="btn btn-success fas fa-file-alt fa-2x" title="Abierto"></i></h5>
                        <h5 class="col-sm-3 text-muted">Cerrado: <i class="btn btn-danger fas fa-file-alt fa-2x" title="Cerrado"></i></h5>
                    </div>
                    <div class="col-sm-6 align-self-end">
                        <h5 class="text-muted text-right">Descargar CSV: <a href="{{ route('docencia.csv.carrera', ['carrera'=>$carrera->id]) }}" class="btn btn-info fas fa-file-csv fa-2x"></a>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                @if (Auth::user()->proyectoDocencia->departamento->carreras->count() > 1) 
                    <a href="{{ route('docencia.buscar.expediente.carrera') }}" class="btn btn-default btn-raised m-1">Atrás</a>
                @else
                    <a href="{{route ('inicio.docencia')}}" class="btn btn-default btn-raised m-1">Atrás</a>
                @endif

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title text-center text-uppercase">{{$carrera->nombre}}</h4>
            </div>
            <div class="panel-body">
                @if(count($expedientes)>0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped default">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. de control</th>
                                <th>Nombre del Alumno</th>
                                <th>Semestre</th>
                                <th>No. de Actividades</th>
                                <th>Expediente</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($expedientes as $expediente)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$expediente->no_de_control}}</td>
                                    <td>{{$expediente->nombre}} {{$expediente->apellido_paterno}} {{$expediente->apellido_materno ? $expediente->apellido_materno : ''}}</td>
                                    <td>{{$expediente->semestre}}°</td>
                                    <td>{{$expediente->numeroActividadesRegistradas}}</td>

                                    <td><a href="{{ route('docencia.expediente.alumno', ['numeroControl' => $expediente->no_de_control]) }}"><button class="btn {{$expediente->datosEstatus['color']}} fas fa-file-alt fa-lg" title="{{$expediente->datosEstatus['nombre']}}"></button></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <h4 class="text-center text-muted">No se tienen registros de expedientes</h4>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
