@extends('layouts.socialEscolares')

@section('contenido')
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">EXPEDIENTE DE CRÉDITOS COMPLEMENTARIOS</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <h5 class="col-sm-3 text-muted">No. Control:  <strong>{{$alumno->no_de_control}}</strong></h5>
                    <h5 class="col-sm-4 text-muted">Nombre:  
                        <strong>
                            {{$alumno->nombre}} {{$alumno->apellido_paterno}} {{$alumno->apellido_materno ? $alumno->apellido_materno : ''}}
                        </strong>
                    </h5>
                    <h5 class="col-sm-5 text-muted">Carrera:  <strong>{{$alumno->carrera->nombre}} {{$alumno->semestre}}°</strong></h5>
                </div>
                <hr>
                <div class="row">
                    <h5 class="col-sm-4 text-muted">Estatus del expediente:  <strong class="{{$expediente->datosEstatus['color']}}">{{$expediente->datosEstatus['nombre']}}</strong></h5>
                    <h5 class="col-sm-4 text-muted">Actividades registradas:  <strong>{{$expediente->numeroActividadesRegistradas}}</strong></h5>
                    <h5 class="col-sm-4 text-muted">Cerditos validados:  <strong>{{$expediente->creditos}}</strong></h5>
                </div>
                <div class="row">
                    <h5 class="col-sm-4 text-muted">Fecha de apertura:  <strong>{{$expediente->fecha_apertura}}</strong></h5>
                    @if ($expediente->fecha_cierre)
                    <h5 class="col-sm-4 text-muted">Fecha de cierre:  <strong>{{$expediente->fecha_cierre}}</strong></h5>
                    @endif
                    <h5 class="col-sm-4 text-muted">Promedio de rubricas:  <strong>{{$expediente->promedio_rubricas}}</strong></h5>
                </div>
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
                            <th style="width: 3em">#</th>
                            <th>Actividad complementaria</th>
                            <th>Valor</th>
                            <th style="width: 13em">Periodo</th>
                            <th style="width: 5em">Estatus</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expediente->actividadesRegistradas as $actividad)
                        <tr>
                            <td class="text-center"><br>{{$loop->iteration}}<br>&nbsp;</td>
                            <td>{{$actividad->creditoComplementario->descripcion}}</td>
                            <td class="text-center">{{$actividad->creditoComplementario->valor}}</td>
                            <td class="text-center">{{$actividad->fecha_inicio}} - {{$actividad->fecha_fin}}</td>   
                            <td class="text-center">
                                <button class="btn {{$actividad->datosEstatus['color']}} btn-raised btn-sm" style="width: 100%; color: black" title="{{$actividad->datosEstatus['descripcion']}}">{{$actividad->datosEstatus['nombre']}}</button>
                            </td>
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection