@extends('layouts.socialEscolares')

@section('contenido')
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">FILTROS PARA BUSCAR EXPEDIENTES CERRADOS</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <p>Buscar por carrera y/o semestre</p>
                    </div>
                    <div class="col-sm-6 text-center">
                        <p>Buscar entre fechas de cierre de expediente</p>
                    </div>
                </div>
                <div class="row">
                    <form action="" method="get" id="form-buscar">
                        @csrf
                        <div class="col-sm-3">
                            <div class="form-group @if (!isset($filtro['carrera'])) label-floating @endif is-empty">
                                <label for="carrera" class="control-label">Carrera</label>
                                <select name="carrera" id="carrera" class="form-control">
                                    <option value=""></option>
                                    @foreach ($carreras as $carrera)
                                    <option value="{{$carrera->id}}" @if (isset($filtro['carrera'])) @if ($carrera->id == $filtro['carrera']) selected @endif @endif>
                                        {{$carrera->nombre}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group @if (!isset($filtro['semestre'])) label-floating @endif is-empty">
                                <label for="semestre" class="control-label">Semestre</label>
                                <select name="semestre" id="semestre" class="form-control">
                                    <option value=""></option>
                                    @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{$i}}" @if (isset($filtro['semestre'])) @if ($i == $filtro['semestre']) selected @endif @endif> {{$i}} °</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group @if (!isset($filtro['fechaInicio'])) label-floating @endif is-empty">
                                <label for="fechaInicio" class="control-label">Fecha de inicio</label> 
                                <input type="text" name="fechaInicio" id="fechaInicio" class="form-control date-picker" value="@if (isset($filtro['fechaInicio'])) {{$filtro['fechaInicio']}} @endif">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group @if (!isset($filtro['fechaFin'])) label-floating @endif is-empty">
                                <label for="fechaFin" class="control-label">Fecha de fin</label> 
                                <input type="text" name="fechaFin" id="fechaFin" class="form-control date-picker" value="@if (isset($filtro['fechaFin'])) {{$filtro['fechaFin']}} @endif">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel-footer text-right">
                @if (isset($expedientes))
                    @if (count($expedientes) > 0)
                    <a href="{{ route('socialEscolares.csv.expedientes.cerrados', ['carrera' => $filtro['carrera'], 'semestre' => $filtro['semestre'], 'fechaInicio' => $filtro['fechaInicio'], 'fechaFin' => $filtro['fechaFin']]) }}" 
                        class="btn btn-info btn-raised" title="Descargar la tabla actual en CSV">
                        <i class="fas fa-cloud-download-alt"></i>&nbsp;&nbsp;&nbsp;Descargar CSV
                    </a>
                    @endif
                @endif
                <button class="btn btn-primary btn-raised" form="form-buscar" type="submit" title="Buscar expedientes cerrados por el filtro dado">
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
            <div class="panel-heading">
                <h3 class="panel-title text-center">EXPEDIENTES CERRADOS</h3>
            </div>
            <div class="panel-body">
                @if (isset($expedientes))
                @if (count($expedientes) == 0)
                <div class="col-sm-12">
                    <h4 class="text-center text-muted">No se encuentran registros de expedientes con los filtros actuales</h4>
                </div> 
                @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped default">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. de control</th>
                                <th>Nombre del Alumno</th>
                                <th>Carrera</th>
                                <th>Semestre</th>
                                <th>Fecha de cierre</th>
                                <th>Promedio</th>
                                <th>Expediente</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expedientes as $expediente)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-center">{{$expediente->no_de_control}}</td>
                                    <td>{{$expediente->alumno->apellido_paterno.' '.($expediente->alumno->apellido_materno ? $expediente->alumno->apellido_materno : '').' '.$expediente->alumno->nombre}}</td>
                                    <td class="text-center">{{$expediente->alumno->carrera->nombre}}</td>
                                    <td class="text-center">{{$expediente->alumno->semestre}}</td>
                                    <td class="text-center">{{$expediente->fecha_cierre}}</td>
                                    <td class="text-center">{{$expediente->promedio_rubricas}}</td>
                                    <td class="text-center">
                                        <a href="{{ route('socialEscolares.expediente.alumno', ['numeroControl' => $expediente->no_de_control]) }}">
                                            <button class="btn btn-primary fas fa-file-alt fa-lg" title="Mostrar el expediente del alumno"></button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                @else
                    <div class="col-sm-12">
                        <h4 class="text-center text-muted">Busque los expedientes por los filtros y presione buscar</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('errores')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <script>new PNotify({ title: 'Error', text: '{{ $error }}', type: 'error' });</script>
        @endforeach
    @endif
@endsection