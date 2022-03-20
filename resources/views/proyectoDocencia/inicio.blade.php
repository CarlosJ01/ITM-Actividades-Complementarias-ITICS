@extends('layouts.docencia')

@section('contenido')
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Bienvenido de nuevo {{strtoupper($docencia->nombre.' '.$docencia->apellido_paterno.' '.($docencia->apellido_materno ? $docencia->apellido_materno : ''))}}</h3>
                </div>
                <div class="panel-body text-center">
                    <h4>{{strtoupper($docencia->nombre.' '.$docencia->apellido_paterno.' '.($docencia->apellido_materno ? $docencia->apellido_materno : ''))}}</h4>
                    <p>Ahora puedes gestionar los creditos complementarios desde el apartado</p>
                    <p>“Créditos Complementarios”</p>
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