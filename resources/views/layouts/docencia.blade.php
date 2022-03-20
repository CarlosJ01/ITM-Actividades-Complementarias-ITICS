@extends('layouts.app')

@section('nombreUsuario')
    {{Auth::user()->proyectoDocencia->nombre.' '.Auth::user()->proyectoDocencia->apellido_paterno.' '.(Auth::user()->proyectoDocencia->apellido_materno ? Auth::user()->proyectoDocencia->apellido_materno : '')}}
@endsection

@section('menu')
    <div class="item">
        <a href="{{ route('inicio.docencia') }}" class="item-dropdown"><i class="fa  fa-chevron-circle-right "></i> Inicio</a>
    </div>
    <div class="item">
        <a href="#collapse-12" class="item-dropdown" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-12"><i class="fa  fa-chevron-circle-right "></i> Créditos Complementarios</a>
        <div class="collapse" id="collapse-12">
            <div class="item">
                <a href="{{ route('docencia.buscar.expediente.alumno') }}" class="item-dropdown">Buscar Expediente</a>
            </div>
            <div class="item">
                <a href="#collapse-13" class="item-dropdown" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-13"><i class="fa  fa-chevron-circle-right "></i> Alumnos</a>
                <div class="collapse" id="collapse-13">
                    <div class="item">
                        <a href="{{ route('docencia.buscar.expediente.carrera') }}" class="item-dropdown">Carrera</a>
                        <a href="{{ route('docencia.buscar.expedientes') }}" class="item-dropdown">Expedientes</a>
                        <a href="{{ route('docencia.buscar.pendientes') }}" class="item-dropdown">Pendientes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="item">
        <a href="#collapse-14" class="item-dropdown" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-14">
            <i class="fa  fa-chevron-circle-right "></i> Administración
        </a>
        <div class="collapse" id="collapse-14">
            <div class="item">
                <a href="{{ route('usuarios.index') }}" class="item-dropdown">Usuarios</a>
            </div>
            <div class="item">
                <a href="" class="item-dropdown">Actividades Complementarias</a>
            </div>
        </div>
    </div>
@endsection