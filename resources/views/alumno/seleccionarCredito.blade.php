@extends('layouts.alumno')

@section('contenido')
<div class="row">
    <div class="col-sm-12">
        <form action="{{ route('alumno.agregar.credito.informacion') }}" method="post">
            @csrf
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">SELECCIONE UNA ACTIVIDAD COMPLEMENTARIA</h3>
                </div>
                <div class="panel-body">
                    @if (count($creditos) > 0)
                    <div class="table-responsive">
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
                    </div>
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
                </div>
                <div class="panel-footer text-right">
                    <a href="{{ route('alumno.expediente') }}" class="btn btn-default btn-raised m-1">Atrás</a>
                    @if(count($creditos) > 0)
                    <input type="submit" class="btn btn-primary btn-raised m-1" value="Siguiente">
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('errores')
    @error('credito')
        <script>new PNotify({ title: 'Error', text: '{{ $message }}', type: 'error' });</script>
    @enderror
@endsection