@extends('layouts.responsable')

@section('contenido')
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">SELECCIONE UN ALUMNO</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped default">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. de control</th>
                                <th>Nombre del Alumno</th>
                                <th>Carrera</th>
                                <th>Rúbricas</th>
                                <th>Info.</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($alumnos as $alumno)
                            <tr>
                                <td>{{$loop->iteration}}<br>&nbsp;</td>
                                <td>{{$alumno->no_de_control}}</td>
                                <td>{{$alumno->nombre}} {{$alumno->apellido_paterno}} {{isset($alumno->apellido_materno) ? $alumno->apellido_materno : ''}}</td>
                                <td>{{$alumno->nombre_carrera}}</td>
                                <td>{{$alumno->numero_creditos}}</td>
                                <td>
                                    <a href="{{ route('responsable.alumno', ['alumno'=>$alumno->no_de_control]) }}" class="btn btn-info btn-raised btn-sm" title="Seleccionar alumno para calificar sus rubricas">
                                        <i class="fa fa-search-plus"></i>
                                    </a>
                                </td>
                            </tr>    
                            @endforeach                       
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer text-right">
                <a href="/responsable-actividad-complementaria" class="btn btn-default btn-raised m-1">Atrás</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('errores')
    @error('credito')
        <script>new PNotify({ title: 'Error', text: '{{ $message }}', type: 'error' });</script>
    @enderror
    @if (session('mensaje'))
        <script>new PNotify({ title: 'Confirmación', text: '{{session('mensaje')}}', type: 'success' });</script>
    @endif
@endsection