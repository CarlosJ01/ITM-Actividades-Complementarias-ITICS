@extends('layouts.responsable')

@section('contenido')
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">ACTIVIDADES COMPLEMENTARIAS A EVALUAR</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped default">
                        <thead>
                            <tr>
                                <th style="width: 3em"></th>
                                <th>Actividad</th>
                                <th style="width: 5em">Valor</th>
                                <th style="width: 5em">Alumnos</th>
                                <th style="width: 7em">Info.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($actividades as $actividad)
                                <tr>
                                    <td class="text-center"><br>{{$loop->iteration}}<br>&nbsp;</td>
                                    <td>{{$actividad->descripcion}}</td>
                                    <td class="text-center">{{$actividad->valor}}</td>
                                    <td class="text-center">{{$actividad->numero_alumnos}}</td>
                                    <td class="text-center">
                                        <a href="{{ route('responsable.actividad', ['actividad'=>$actividad->id]) }}" class="btn btn-info btn-raised btn-sm" title="Información de los alumnos de la actividad">
                                            <i class="fa fa-search-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('errores')
    @if (session('mensaje'))
        <script>new PNotify({ title: 'Confirmación', text: '{{session('mensaje')}}', type: 'success' });</script>
    @endif
@endsection