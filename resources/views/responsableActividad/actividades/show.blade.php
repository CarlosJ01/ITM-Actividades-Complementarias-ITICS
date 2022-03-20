@extends('layouts.responsable')

@section('contenido')
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">INFORMACIÓN DE LA ACTIVIDAD COMPLEMENTARIA A EVALUAR</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 text-muted">Actividad: <strong>{{$actividad->descripcion}}</strong></div>
                    <div class="col-md-12 text-muted">Valor: <strong>{{$actividad->valor}}</strong></div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-muted">Departamento: <strong>{{$actividad->departamento->nombre}}</strong></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Alumnos a evaluar</h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped default">
                                <thead>
                                    <tr>
                                        <th style="width: 3em">#</th>
                                        <th>No. de control</th>
                                        <th>Alumno</th>
                                        <th style="width: 15em">Periodo de realización</th>
                                        <th style="width: 5em">Evidencia</th>
                                        <th style="width: 10em">Fecha de registro</th>
                                        <th style="width: 15em">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alumnos as $alumno)
                                        <tr>
                                            <td class="text-center"><br>{{$loop->iteration}}<br>&nbsp;</td>
                                            <td class="text-center">{{$alumno->no_de_control}}</td>
                                            <td>{{$alumno->nombre.' '.$alumno->apellido_paterno.' '.($alumno->apellido_materno ? $alumno->apellido_materno : '')}}</td>
                                            <td class="text-center">{{$alumno->fecha_inicio.' - '.$alumno->fecha_fin}}</td>
                                            <td class="text-center">
                                                <a href="{{$alumno->enlace_evidencia}}" class="btn btn-info btn-raised btn-sm m-3" title="Evidencia PDF de la actividad complementaria" target="_blank"><i class="far fa-file-alt"></i></a>
                                            </td>
                                            <td class="text-center">{{$alumno->updated_at}}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-info btn-raised btn-sm m-3" title="Mostrar el comentario realizado" data-toggle="modal" data-target="#modalComentario{{$alumno->idActividad}}"><i class="far fa-comments"></i></button>
                                                <a href="{{ route('responsable.rubrica.individual', ['rubrica'=>$alumno->idRubrica]) }}" class="btn btn-primary btn-raised btn-sm m-3" title="Calificar la rúbrica de evaluación del alumno"><i class="fas fa-paste"></i></a>
                                                <button type="button" class="btn btn-danger btn-raised btn-sm m-3" title="Rechazar la actividad complementaria" data-toggle="modal" data-target="#modalRechazar{{$alumno->idActividad}}"><i class="far fa-times-circle"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                <a href="{{ route('responsable.actividades') }}" class="btn btn-default btn-raised m-1">Atrás</a>
                <a href="{{ route('responsable.rubrica.masivamente', ['credito'=>$actividad->id]) }}" class="btn btn-primary btn-raised m-1" title="Calificar la rúbrica de evaluación de todos los alumnos en la actividad">
                    <i class="fas fa-paste"></i>&nbsp;&nbsp;&nbsp;Calificar masivamente
                </a>
            </div>
        </div>
    </div>
</div>

@foreach ($alumnos as $alumno)
<div class="modal fade" id="modalComentario{{$alumno->idActividad}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel{{$alumno->idActividad}}">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background: #03a9f4;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel{{$alumno->idActividad}}">Comentario</h4>
          <br>
        </div>
        <div class="modal-body">
            <h4>{{$alumno->comentario}}</h4>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalRechazar{{$alumno->idActividad}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel{{$alumno->idActividad}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #e57373">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel{{$alumno->idActividad}}">Rechazar la actividad complementaria del alumno</h4>
                <br>
            </div>
            <div class="modal-body">
                <p class="text-danger">*  Realiza un comentario para indicarle al alumno cual fue el motivo del rechazo</p>
                <form action="{{ route('responsable.actividad.rechazar.v1') }}" id="formRechazar{{$alumno->idActividad}}" method="post">
                    @csrf
                    <input type="hidden" name="actividad" value="{{$alumno->idActividad}}">
                    <div class="form-group">
                        <label for="comentario">Comentario:</label>
                        <textarea id="comentario" class="form-control" name="comentario" rows="5"></textarea>
                    </div>
                </form>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-raised" data-dismiss="modal">Cerrar</button>
                <button type="submit" form="formRechazar{{$alumno->idActividad}}" class="btn btn-danger btn-raised" title="Rechazar la actividad y enviar el comentario realizado al alumno">Rechazar</button>
            </div>
        </div>
    </div>
</div>
@endforeach
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