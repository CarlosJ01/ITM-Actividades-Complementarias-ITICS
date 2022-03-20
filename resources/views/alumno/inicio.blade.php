@extends('layouts.alumno')

@section('contenido')
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Bienvenido de nuevo {{strtoupper($alumno->nombre.' '.$alumno->apellido_paterno.' '.($alumno->apellido_materno ? $alumno->apellido_materno : ''))}}</h3>
                </div>
                <div class="panel-body text-center">
                    <h4>({{$alumno->no_de_control}})<br>{{strtoupper($alumno->nombre.' '.$alumno->apellido_paterno.' '.($alumno->apellido_materno ? $alumno->apellido_materno : ''))}}</h4>
                    <p>Ahora puedes gestionar tus créditos complementarios, desde "créditos complementarios" -&gt; "Expediente"</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('errores')
    @if (session('mensaje'))
        <script>new PNotify({ title: 'Confirmación', text: '{{session('mensaje')}}', type: 'success' });</script>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <script>new PNotify({ title: 'Error', text: '{{ $error }}', type: 'error' });</script>
        @endforeach
    @endif
@endsection
