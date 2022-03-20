@extends('layouts.alumno')

@section('contenido')
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">SELECCIONE UN NUEVO CRÉDITO COMPLEMENTARIO</h3>
            </div>
            <div class="panel-body">
                <form action="{{ route('alumno.update.actividad.credito') }}" id="formEditarCredito" method="post">
                    @csrf
                    <input type="hidden" name="actividad" value="{{$actividad}}">
                    @if (count($creditos) > 0)
                    <table class="table table-bordered table-striped default">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Descripción</th>
                                <th>Valor</th>
                                <th>Seleccionar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($creditos as $credito)
                            <tr>
                                @if (!isset(explode(".", $credito->numero)[1]))
                                <td class="text-center">{{$credito->numero}}</td>
                                @else
                                <td class="text-center">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{$credito->numero}}
                                    &nbsp;&nbsp;
                                </td>
                                @endif
                                <td>{{$credito->descripcion}}</td>
                                @if ($credito->valor != 0)
                                <td class="text-center">
                                    {{$credito->valor}}
                                </td>
                                <td class="text-center">
                                    <input type="radio" name="credito" value="{{$credito->id}}" @if ($credito->id == $creditoSeleccionado) checked @endif>
                                </td>
                                @else
                                <td></td>
                                <td></td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-dismissible alert-danger">
                                <button type="button" data-dismiss="alert" class="close">×</button> 
                                <strong>Tu departamento no tiene créditos complementarios disponibles</strong>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
                <form action="{{ route('alumno.actividad.editar') }}" id="formEditarActividad" method="post">
                    @csrf
                    <input type="hidden" name="actividad" value="{{$actividad}}">
                </form>
            </div>
            <div class="panel-footer text-right">
                <button type="submit" form="formEditarActividad" class="btn btn-default btn-raised m-1">Atrás</button>
                @if(count($creditos) > 0)
                <button type="submit" form="formEditarCredito" class="btn btn-warning btn-raised m-1" style="color: black" title="Actualizar el crédito complementario registrado">
                    <i class="far fa-save"></i>&nbsp;&nbsp;&nbsp;Actualizar
                </button>
                @endif
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