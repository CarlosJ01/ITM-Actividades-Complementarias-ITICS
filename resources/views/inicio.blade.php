@extends('layouts.main')

@section('contenido')
    <div class="panel panel-default">
        <div class="panel-heading image text-center">
            <img src="{{ asset('img/tnm.png') }}" alt="Logo Tec" class="img-heading hidden-xs">
            <h3 class="panel-title">Instituto Tecnológico de Morelia</h3>
            <img src="{{ asset('img/itm.png') }}" alt="Logo Tec" class="img-heading hidden-xs">
        </div>
        <div class="panel-body">
            <p class="text-center">Bienvenido al Sistema de Gestión Escolar, por favor selecciona la opción de acuerdo a tus actividades.</p>
            <br>
            <ul class="nav nav-pills nav-center">
                <li role="presentation" class="active"><a href="{{ route('inicio') }}">Inicio</a></li>
                <li role="presentation"><a href="{{ route('login.administrativo') }}">Personal del Instituto</a></li> 
                <li role="presentation"><a href="{{ route('login.alumno') }}">Alumno</a></li>
            </ul>
        </div>
    </div>
@endsection