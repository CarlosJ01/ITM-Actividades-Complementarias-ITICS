@extends('layouts.docencia')

@section('contenido')
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">BUSCAR UN EXPEDIENTE POR NÚMERO DE CONTROL</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">
                            <form action="{{ route('docencia.expediente.buscar') }}" method="post" id="form-buscar-expediente">
                                @csrf
                                <div class="form-group label-floating @if (!old('numeroControl')) is-empty @endif">
                                    <label for="numeroControl" class="control-label">Numero de control</label> 
                                    <input type="text" name="numeroControl" id="numeroControl" class="form-control" maxlength="10" required value="{{ old('numeroControl') }}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button class="btn btn-primary btn-raised" form="form-buscar-expediente" type="submit" title="Buscar el expediente de un alumno por su número de control">
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