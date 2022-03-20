@extends('layouts.alumno')

@section('contenido')
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">EXPEDIENTE DE CRÉDITOS COMPLEMENTARIOS</h3>
                </div>
                <div class="panel-body text-center">
                    <h4>No tienes un expediente de créditos complementarios abierto</h4>
                </div>
                <div class="panel-footer text-right">
                    <form action="{{ route('alumno.expediente.abrir') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-success btn-raised" title="Abrir un expediente de créditos complementarios"><i class="fas fa-folder-open"></i>&nbsp;&nbsp;&nbsp;Abrir expediente</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
