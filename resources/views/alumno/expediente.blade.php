@extends('layouts.alumno')

@section('contenido')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">EXPEDIENTE DE CRÉDITOS COMPLEMENTARIOS</h3>
                </div>
                <div class="panel-body">
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
                @if (!$expediente->estatus && $expediente->url_constancia_liberacion)
                <div class="panel-footer text-right">
                    <a href="{{$expediente->url_constancia_liberacion}}" class="btn btn-primary btn-raised" title="Descargar la constancia de liberación de créditos complementarios" target="_blank">
                        <i class="fas fa-cloud-download-alt"></i>&nbsp;&nbsp;&nbsp;Constancia de Liberación
                    </a>
                </div>
                @endif
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
                                <th>Crédito complementario</th>
                                <th>Valor</th>
                                <th>Fecha de inicio</th>
                                <th>Fecha de terminación</th>
                                <th style="width: 9em">Documentos</th>
                                <th style="width: 5em">Estatus</th>
                                <th style="width: 9em">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expediente->actividadesRegistradas as $actividad)
                            <tr>
                                <td class="text-center"><br>{{$actividad->numeroCredito}}<br>&nbsp;</td>
                                <td>{{$actividad->creditoComplementario->descripcion}}</td>
                                <td class="text-center">{{$actividad->creditoComplementario->valor}}</td>
                                <td class="text-center">{{$actividad->fecha_inicio}}</td>
                                <td class="text-center">{{$actividad->fecha_fin}}</td>
                                <td class="text-center">
                                    <a href="{{$actividad->enlace_evidencia}}" class="btn btn-danger btn-raised btn-sm m-3" title="Evidencia PDF de la actividad complementaria" target="_blank"><i class="far fa-file-alt"></i></a>
                                    <button type="submit" form="formRubrica{{$actividad->id}}" class="btn btn-info btn-raised btn-sm m-3" title="Rubrica de evaluación de la actividad complementaria"><i class="far fa-clipboard"></i></button>
                                </td>
                                <td class="text-center">
                                    <button class="btn {{$actividad->datosEstatus['color']}} btn-raised btn-sm" style="width: 100%; color: black" title="{{$actividad->datosEstatus['descripcion']}}">{{$actividad->datosEstatus['nombre']}}</button>
                                </td>
                                <td class="text-center">
                                    @if ($actividad->estatus == 2 || $actividad->estatus == 4)
                                    <button type="submit" form="formEditarActividad{{$actividad->id}}" class="btn btn-warning btn-raised btn-sm m-3" style="color: black" title="Editar la información de la actividad complementaria"><i class="far fa-edit"></i></button>
                                    @endif
                                    <button type="button" class="btn btn-info btn-raised btn-sm m-3" title="Mostrar el comentario realizado" data-toggle="modal" data-target="#modalComentario{{$actividad->id}}"><i class="far fa-comments"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer text-right">
                    @if ($expediente->numeroActividadesRegistradas < 5 && $expediente->numeroCreditosRegistrados < 5 && $expediente->estatus)
                    <a href="{{ route('alumno.agregar.credito.seleccion') }}" class="btn btn-primary btn-raised"  title="Agregar una nueva actividad complementaria">
                        <i class="fas fa-plus-circle"></i>&nbsp;&nbsp;&nbsp;Agregar actividad
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- No lo elemine pliss --}}
    <script>
        console.log('17120151 => Carlos Jahir Castro Cázares');
        console.log('17120182 => Giovanni Hasid Martínez Reséndiz');
    </script>
    
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

    <form action="{{ route('alumno.rubrica.actividad') }}" id="formRubrica{{$actividad->id}}" method="post">
        @csrf
        <input type="hidden" name="idRubrica" value="{{$actividad->id_rubrica_evaluacion_credito}}">
    </form>

    @if ($actividad->estatus == 2 || $actividad->estatus == 4)
    <form action="{{ route('alumno.actividad.editar') }}" id="formEditarActividad{{$actividad->id}}" method="post">
        @csrf
        <input type="hidden" name="actividad" value="{{$actividad->id}}">
    </form>
    @endif
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
