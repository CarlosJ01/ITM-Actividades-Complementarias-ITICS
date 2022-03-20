@extends('layouts.docencia')

@section('contenido')
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">BUSCAR EXPEDIENTES</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">
                            <form action="{{ route('docencia.expedientes.buscar') }}" method="post" id="form-buscar-carrera">
                                @csrf
                                <div class="form-group label-floating">
                                    <p>Consultar expedientes:</p>
                                    <select name="estatus" id="expediente" class="form-control">
                                        <option value="3" selected disabled>Seleccione una opción</option>
                                        <option value="1">Abierto</option>
                                        <option value="0">Cerrado</option>
                                    </select> 
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button class="btn btn-primary btn-raised" form="form-buscar-carrera" type="submit" title="Buscar los expedientes de una carrera" id="buscar">
                        <i class="fas fa-search"></i>&nbsp;&nbsp;&nbsp;Buscar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('errores')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <script>new PNotify({ title: 'Error', text: '{{ $error }}', type: 'error' });</script>
        @endforeach
    @endif
@endsection