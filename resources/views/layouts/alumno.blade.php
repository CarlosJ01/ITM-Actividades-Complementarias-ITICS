@extends('layouts.app')

@section('nombreUsuario')
    {{Auth::user()->alumno->nombre.' '.Auth::user()->alumno->apellido_paterno.' '.(Auth::user()->alumno->apellido_materno ? Auth::user()->alumno->apellido_materno : '')}}
@endsection

@section('menu')
    <div class="item">
        <a href="{{ route('inicio.alumno') }}" class="item-dropdown"><i class="fa  fa-chevron-circle-right "></i> Inicio</a>
    </div>
    <div class="item">
        <a href="#collapse-12" class="item-dropdown" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-12"><i class="fa  fa-chevron-circle-right "></i> Créditos complementarios</a>
        <div class="collapse" id="collapse-12">
            <div class="item">
                <a href="{{ route('alumno.expediente') }}" class="item-dropdown">Expediente</a>
            </div>
        </div>
    </div>
@endsection