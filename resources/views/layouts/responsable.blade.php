@extends('layouts.app')

@section('nombreUsuario')
    {{Auth::user()->responsableActividad->nombre.' '.Auth::user()->responsableActividad->apellido_paterno.' '.(Auth::user()->responsableActividad->apellido_materno ? Auth::user()->responsableActividad->apellido_materno : '')}}
@endsection

@section('menu')
    <div class="item">
        <a href="{{ route('inicio.responsable') }}" class="item-dropdown"><i class="fa  fa-chevron-circle-right "></i> Inicio</a>
    </div>
    <div class="item">
        <a href="#collapse-12" class="item-dropdown" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-12"><i class="fa  fa-chevron-circle-right "></i> Actividades Complementarias</a>
        <div class="collapse" id="collapse-12">
            <div class="item">
                <a href="{{ route('responsable.rubricas-alumno') }}" class="item-dropdown">Calificar Alumnos</a>
                <a href="{{ route('responsable.actividades') }}" class="item-dropdown">Calificar Actividades</a>
            </div>
        </div>
    </div>
@endsection