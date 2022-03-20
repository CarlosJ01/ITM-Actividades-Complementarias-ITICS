@extends('layouts.app')

@section('nombreUsuario')
    {{Auth::user()->socialEscolares->nombre.' '.Auth::user()->socialEscolares->apellido_paterno.' '.(Auth::user()->socialEscolares->apellido_materno ? Auth::user()->socialEscolares->apellido_materno : '')}}
@endsection

@section('menu')
    <div class="item">
        <a href="{{ route('inicio.socialEscolares') }}" class="item-dropdown"><i class="fa  fa-chevron-circle-right "></i> Inicio</a>
    </div>
    <div class="item">
        <a href="#collapse-12" class="item-dropdown" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-12"><i class="fa  fa-chevron-circle-right "></i> Créditos Complementarios</a>
        <div class="collapse" id="collapse-12">
            <div class="item">
                <a href="{{ route('socialEscolares.buscar.expediente') }}" class="item-dropdown">Buscar Expediente</a>
            </div>
            <div class="item">
                <a href="{{ route('socialEscolares.expedientes.cerrados') }}" class="item-dropdown">Expedientes Cerrados</a>
            </div>
        </div>
    </div>
@endsection