@extends('layouts.main')

@section('contenido')
    <form action="{{ route('autenticacion.alumno') }}" method="post">
        @csrf
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
                    <li role="presentation"><a href="{{ route('inicio') }}">Inicio</a></li>
                    <li role="presentation"><a href="{{ route('login.administrativo') }}">Personal del Instituto</a></li> 
                    <li role="presentation" class="active"><a href="{{ route('login.alumno') }}">Alumno</a></li>
                </ul>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="form-group label-floating @if (!old('usuario')) is-empty @endif">
                            <label for="usuario" class="control-label">Número de control</label>
                            <input type="text" name="usuario" id="usuario" value="{{ old('usuario') }}" class="form-control">
                        </div>
                        <div class="form-group label-floating is-empty">
                            <label for="password" class="control-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                <button type="submit" class="btn btn-primary btn-raised btn-sm"><i class="fas fa-sign-in-alt"></i> Acceder</button>
            </div>
        </div>     
    </form>
@endsection

@section('errores')
    @error('password')
        <script>new PNotify({ title: 'Error', text: '{{ $message }}', type: 'error' });</script>
    @enderror
    
    @error('usuario')
        <script>new PNotify({ title: 'Error', text: '{{ $message }}', type: 'error' });</script>
    @enderror
@endsection