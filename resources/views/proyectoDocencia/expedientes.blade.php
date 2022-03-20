@extends('layouts.docencia')

@section('contenido')
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">EXPEDIENTES DE CREDITOS COMPLEMENTARIOS ( {{ $estatus=='1' ? 'ABIERTO' : 'CERRADO' }} )</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <form action="{{ route('docencia.expedientes.buscar') }}" method="post" id="form-buscar-carrera">
                            @csrf
                            <div class="form-group label-floating">
                                <p>Consultar expedientes:</p>
                                <select name="estatus" id="expediente" class="form-control">
                                    <option value="3" selected disabled>Seleccione una opción</option>
                                    <option value="1" {{ $estatus=='1' ? 'selected="selected"' : '' }}>Abierto</option>
                                    <option value="0" {{ $estatus=='0' ? 'selected="selected"' : '' }}>Cerrado</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="row">
                            <div class="col-sm-6">
                                <h5 class="col-sm-3 {{ $estatus=='1' ? '' : 'text-muted' }}">Abierto: <i class="btn btn-success fas fa-file-alt fa-2x" title="Abierto"></i></h5>
                                <h5 class="col-sm-3 {{ $estatus=='0' ? '' : 'text-muted' }}">Cerrado: <i class="btn btn-danger fas fa-file-alt fa-2x" title="Cerrado"></i></h5>
                            </div>
                            <div class="col-sm-6 align-self-end">
                                <h5 class="text-muted text-right">Descargar CSV: <a href="{{ route('docencia.csv.estatus', ['estatus'=>$estatus]) }}" class="btn btn-info fas fa-file-csv fa-2x"></a>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="estatus" value="{{$estatus}}">
            <div class="panel-footer text-right">
                <a href="{{route ('inicio.docencia')}}" class="btn btn-default btn-raised m-1">Atrás</a>

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
                            <th colspan="7">ACTIVIDADES COMPLEMENTARIAS REGISTRADAS</td>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>No. de control</th>
                            <th>Nombre del Alumno</th>
                            <th>Semestre</th>
                            <th>No. de Actividades</th>
                            <th>Promedio</th>
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
                            <td>{{$expediente->promedio_rubricas}}</td>
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

@endsection