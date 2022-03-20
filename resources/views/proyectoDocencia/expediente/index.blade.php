@extends('layouts.docencia')

@section('contenido')
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">EXPEDIENTE DE CRÉDITOS COMPLEMENTARIOS</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <h5 class="col-sm-3 text-muted">No. Control:  <strong>{{$alumno->no_de_control}}</strong></h5>
                    <h5 class="col-sm-4 text-muted">Nombre:  
                        <strong>
                            {{$alumno->nombre}} {{$alumno->apellido_paterno}} {{$alumno->apellido_materno ? $alumno->apellido_materno : ''}}
                        </strong>
                    </h5>
                    <h5 class="col-sm-5 text-muted">Carrera:  <strong>{{$alumno->carrera->nombre}} {{$alumno->semestre}}°</strong></h5>
                </div>
                <hr>
                <div class="row">
                    <h5 class="col-sm-4 text-muted">Estatus del expediente:  <strong class="{{$expediente->datosEstatus['color']}}">{{$expediente->datosEstatus['nombre']}}</strong></h5>
                    <h5 class="col-sm-4 text-muted">Actividades registradas:  <strong>{{$expediente->numeroActividadesRegistradas}}</strong></h5>
                    <h5 class="col-sm-4 text-muted">Créditos validados:  <strong>{{$expediente->creditos}}</strong></h5>
                </div>
                <div class="row">
                    <h5 class="col-sm-4 text-muted">Fecha de apertura:  <strong>{{$expediente->fecha_apertura}}</strong></h5>
                    @if ($expediente->fecha_cierre)
                    <h5 class="col-sm-4 text-muted">Fecha de cierre:  <strong>{{$expediente->fecha_cierre}}</strong></h5>
                    @endif
                    <h5 class="col-sm-4 text-muted">Promedio de rubricas:  <strong>{{$expediente->promedio_rubricas}}</strong></h5>
                </div>
            </div>
            <div class="panel-footer text-right">
                @if ($expediente->estatus && $expediente->creditos >= 5)
                <a href="{{ route('docencia.descargar.plantilla.constancia', ['numeroControl'=>$alumno->no_de_control]) }}" class="btn btn-info btn-raised" title="Descargar la plantilla de la constancia de liberación de créditos complementarios">
                    <i class="fas fa-cloud-download-alt"></i>&nbsp;&nbsp;&nbsp;Descargar plantilla
                </a>
                <button type="button" class="btn btn-danger btn-raised" data-toggle="modal" data-target="#subirConstancia" title="Subir la constancia de créditos complementarios y cerrar el expediente">
                    <i class="fas fa-cloud-upload-alt"></i>&nbsp;&nbsp;&nbsp;Subir constancia
                </button>
                @endif
                @if (!$expediente->estatus && $expediente->url_constancia_liberacion)
                <a href="{{$expediente->url_constancia_liberacion}}" class="btn btn-info btn-raised" title="Descargar la constancia de liberación de créditos complementarios" target="_blank">
                    <i class="fas fa-cloud-download-alt"></i>&nbsp;&nbsp;&nbsp;Constancia de Liberación
                </a>
                @endif
                <a href="{{ route('docencia.buscar.expediente.alumno') }}" class="btn btn-default btn-raised">Atrás</a>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="table-responsive">
                <table class="table table-bordered table-striped default">
                    <thead>
                        <tr>
                            <th colspan="8">ACTIVIDADES COMPLEMENTARIAS REGISTRADAS</td>
                        </tr>
                        <tr>
                            <th style="width: 3em">#</th>
                            <th>Actividad complementaria</th>
                            <th>Valor</th>
                            <th style="width: 13em">Periodo</th>
                            <th style="width: 9em">Documentos</th>
                            <th style="width: 5em">Estatus</th>
                            <th style="width: 9em">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expediente->actividadesRegistradas as $actividad)
                        <tr>
                            <td class="text-center"><br>{{$loop->iteration}}<br>&nbsp;</td>
                            <td>{{$actividad->creditoComplementario->descripcion}}</td>
                            <td class="text-center">{{$actividad->creditoComplementario->valor}}</td>
                            <td class="text-center">{{$actividad->fecha_inicio}} - {{$actividad->fecha_fin}}</td>
                            <td class="text-center">
                                <a href="{{$actividad->enlace_evidencia}}" class="btn btn-danger btn-raised btn-sm m-3" title="Evidencia PDF de la actividad complementaria" target="_blank"><i class="far fa-file-alt"></i></a>
                                <a href="{{ route('docencia.rubrica.actividad', ['numeroControl' => $alumno->no_de_control, 'rubrica' => $actividad->id_rubrica_evaluacion_credito]) }}" class="btn btn-info btn-raised btn-sm m-3" title="Rubrica de evaluación de la actividad complementaria"><i class="far fa-clipboard"></i></a>
                            </td>
                            <td class="text-center">
                                <button class="btn {{$actividad->datosEstatus['color']}} btn-raised btn-sm" style="width: 100%; color: black" title="{{$actividad->datosEstatus['descripcion']}}">{{$actividad->datosEstatus['nombre']}}</button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-info btn-raised btn-sm m-3" title="Mostrar el comentario realizado" data-toggle="modal" data-target="#modalComentario{{$actividad->id}}"><i class="far fa-comments"></i></button>
                                @if ($actividad->estatus == 3)
                                <button type="button" class="btn btn-primary btn-raised btn-sm m-3" data-toggle="modal" data-target="#evaluarModal{{$actividad->id}}" title="Evaluar la actividad complementaria">
                                    <i class="fas fa-paste"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach ($expediente->actividadesRegistradas as $actividad)
    <div class="modal fade" id="modalComentario{{$actividad->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel{{$actividad->id}}">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background: #03a9f4;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel{{$actividad->id}}">Comentario</h4>
              <br>
            </div>
            <div class="modal-body">
                <h4>{{$actividad->comentario}}</h4>
            </div>
          </div>
        </div>
    </div>

    @if ($actividad->estatus == 3)
    <div class="modal fade" id="evaluarModal{{$actividad->id}}" tabindex="-1" role="dialog" aria-labelledby="evaluarModal{{$actividad->id}}Label">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="evaluarModal{{$actividad->id}}Label">Evaluar actividad complementaria</h4>
              <br>
            </div>
            <div class="modal-body">
                <form action="{{ route('docencia.evaluar.actividad') }}" method="POST" id="form-evaluar-actividad{{$actividad->id}}">
                    @csrf
                    <input type="hidden" name="actividad" value="{{$actividad->id}}">
                    <div class="text-right">
                        <strong class="text-danger">* Los cambios no se pueden cambiar posteriormente</strong>
                    </div>
                    <hr>
                    <p>Al evaluar la actividad complementaria seleccione una de las siguientes acciones:</p>
                    <input type="radio" name="evaluacion" id="evaluacion1" value="1" checked required> <strong>Validar: </strong> La información y documentos de la actividad son correctos y su valor pasara a sumarse al alumno.
                    <br><br>
                    <input type="radio" name="evaluacion" id="evaluacion2" value="2" required> <strong>Rechazar: </strong> Alguna información o documento de la actividad son incorrectos y se regresa al alumno para correcciones.
                    <br><br>
                    <input type="radio" name="evaluacion" id="evaluacion3" value="3" required> <strong>Eliminar: </strong> Se eliminará todo lo relacionado con la actividad y no podrán ser recuperados.
                    <div class="form-group">
                        <label for="comentario">Comentario:</label>
                        <textarea id="comentario" class="form-control" name="comentario" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-raised" data-dismiss="modal">Cerrar</button>
              <button type="submit" form="form-evaluar-actividad{{$actividad->id}}" class="btn btn-primary btn-raised">Evaluar&nbsp;&nbsp;&nbsp;<i class="fas fa-paste"></i></button>
            </div>
          </div>
        </div>
    </div>
    @endif
@endforeach

@if ($expediente->estatus && $expediente->creditos >= 5)
<div class="modal fade" id="subirConstancia" tabindex="-1" role="dialog" aria-labelledby="subirConstanciaLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e57373">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="subirConstanciaLabel">Subir constancia y Cerrar expediente</h4>
          <br>
        </div>
        <div class="modal-body">
            <div class="text-right">
                <p class="text-danger"><strong>* Esta acción no pude ser cambiada</strong></p>
            </div>
            <strong>Al subir la constancia de liberación, el expediente actual se cerrará, las actividades en espera o rechazadas se eliminaran y no se podrán realizar cambios posteriormente.</strong>
            <hr>
            <form action="{{ route('docencia.cerrar.expediente') }}" method="post" enctype="multipart/form-data" id="form-constancia">
                @csrf
                <input type="hidden" name="numeroControl" value="{{$alumno->no_de_control}}">
                <label for="urlConstancia" style="color: black"><b>Enlace compartido de la Constancia de Terminación</b></label>
                <input type="url" name="urlConstancia" id="urlConstancia" class="form-control" autofocus required>
                <p class="help-block text-danger">
                    Debe ser un enlace compartido con permisos para que el alumno pueda descargarlo y sin fecha de expiración.
                </p>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-raised" data-dismiss="modal">Cerrar</button>
            <button type="submit" form="form-constancia" class="btn btn-danger btn-raised" title="Subir la constancia de liberación y cerrar el expediente actual">
                <i class="fas fa-check-circle"></i>&nbsp;&nbsp;&nbsp;Aceptar
            </button>
        </div>
      </div>
    </div>
</div>
@endif

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