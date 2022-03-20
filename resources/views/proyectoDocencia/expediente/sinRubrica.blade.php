@extends('layouts.docencia')

@section('contenido')
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">Ha ocurrido un error</h3>
            </div>
            <div class="panel-body text-center">
                <h4>La rúbrica de evaluación no ha sido contestada por el responsable de la actividad complementaria</h4>
                <p><strong>Responsable:</strong> {{$responsable->nombre.' '.$responsable->apellido_paterno.' '.($responsable->apellido_materno ? $responsable->apellido_materno : '')}}</p>
            </div>
            <div class="panel-footer text-right">
                <a href="{{ route('docencia.expediente.alumno', ['numeroControl' => $numeroControl]) }}" class="btn btn-default btn-raised btn-sm">Atrás</a>
            </div>
        </div>
    </div>
</div>
@endsection