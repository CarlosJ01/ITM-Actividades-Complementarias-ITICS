@extends('layouts.responsable')

@section('contenido')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">INFORMACIÓN DEL ALUMNO</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <h5 class="col-sm-8 text-muted">Nombre del alumno: <strong>{{$alumno['nombre']}} {{$alumno['apellido_paterno']}} {{isset($alumno['apellido_materno']) ? $alumno['apellido_materno'] : ''}}</strong></h5>
                        <h5 class="col-sm-4 text-muted">No. De Control: <strong>{{$alumno['no_de_control']}}</strong></h5>
                        <h5 class="col-sm-8 text-muted">Carrera: <strong>{{$alumno['carrera']['nombre']}}</strong></h5>
                        <h5 class="col-sm-4 text-muted">Semestre: <strong>{{$alumno['semestre']}}°</strong></h5>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <a href="/responsable-actividad-complementaria/rubricas-alumno" class="btn btn-default btn-raised m-1">Atrás</a>
                </div>
            </div>
        </div>
    </div>
    @foreach ($actividades as $actividad)
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">EVALUACIÓN AL DESEMPEÑO DE LA ACTIVIDAD COMPLEMENTARIA</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <h5 class="col-sm-9 text-muted">Nombre de la actividad: <strong>{{$actividad->descripcion}}</strong></h5>
                        <h5 class="col-sm-3 text-muted">Valor: <strong>{{$actividad->valor}}</strong></h5>
                        <h5 class="col-sm-12 text-muted">Periodo de registro: <strong>{{$actividad->periodo}}</strong></h5>
                        <h5 class="col-sm-12 text-muted">Periodo de realización: <strong>{{$actividad->fecha_inicio.' - '.$actividad->fecha_fin}} </strong></h5>
                        <div class="col-sm-12">
                            <h5 class="text-muted">Enlace de la evidencia: <a href="{{$actividad->enlace_evidencia}}" class="btn btn-info btn-raised btn-sm m-3 ml-5" title="Evidencia PDF de la actividad complementaria" target="_blank"><i class="far fa-file-alt"></i></a></h5>
                        </div>
                        <div class="col-sm-12">
                            <h5 class="text-muted">Comentario realizado: <button type="button" class="btn btn-info btn-raised btn-sm m-3" title="Mostrar el comentario realizado" data-toggle="modal" data-target="#modalComentario{{$loop->iteration}}"><i class="far fa-comments"></i></button></h5>
                        </div>
                        <div class="col-sm-12 text-right">
                            Rechazar: &nbsp;
                            <button type="button" class="btn btn-danger btn-raised btn-sm m-3" title="Rechazar la actividad complementaria" data-toggle="modal" data-target="#modalRechazar{{$loop->iteration}}"><i class="far fa-times-circle"></i></button>    
                        </div>
                    </div>
                    <br>
                    <form action="{{ route('responsable.calificar.rubrica') }}" method="post" id="formCalificarRubrica{{$loop->iteration}}">
                        @csrf
                        <input type="hidden" name="rubrica" value="{{$actividad->idRubrica}}">
                        <input type="hidden" name="no_de_control" value="{{$alumno->no_de_control}}">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped default">
                                        <thead>
                                            <tr>
                                                <th colspan="2"></th>
                                                <th colspan="5">Nivel de desempeño del criterio</th>
                                            </tr>
                                            <tr>
                                                <th>No.</th>
                                                <th style="width: 35em">Criterios a evaluar</th>
                                                <th>Insuficiente (0)</th>
                                                <th>Suficiente (1)</th>
                                                <th>Bueno (2)</th>
                                                <th>Notable (3)</th>
                                                <th>Excelente (4)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td>Cumple en tiempo y forma con las actividades encomendadas alcanzando los objetivos.</td>
                                                @for ($i = 0; $i < 5; $i++)
                                                <td class="text-center criterio{{$loop->iteration}}"><input type="radio" name="criterio_1" id="criterio_1_{{$loop->iteration.'_'.$i}}"value="{{$i}}" @if ($i == 0) checked @endif required></td>
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td>Trabaja en equipo y se adapta a nuevas situaciones.</td>
                                                @for ($i = 0; $i < 5; $i++)
                                                <td class="text-center criterio{{$loop->iteration}}"><input type="radio" name="criterio_2" id="criterio_2_{{$loop->iteration.'_'.$i}}"value="{{$i}}" @if ($i == 0) checked @endif required></td>
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td>Muestra liderazgo en las actividades encomendadas.</td>
                                                @for ($i = 0; $i < 5; $i++)
                                                <td class="text-center criterio{{$loop->iteration}}"><input type="radio" name="criterio_3" id="criterio_3_{{$loop->iteration.'_'.$i}}"value="{{$i}}" @if ($i == 0) checked @endif required></td>
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td class="text-center">4</td>
                                                <td>Organiza su tiempo y trabaja de manera proactiva.</td>
                                                @for ($i = 0; $i < 5; $i++)
                                                <td class="text-center criterio{{$loop->iteration}}"><input type="radio" name="criterio_4" id="criterio_4_{{$loop->iteration.'_'.$i}}"value="{{$i}}" @if ($i == 0) checked @endif required></td>
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td class="text-center">5</td>
                                                <td>Interpreta la realidad y se sensibiliza aportando soluciones a la problemática con la actividad complementaria.</td>
                                                @for ($i = 0; $i < 5; $i++)
                                                <td class="text-center criterio{{$loop->iteration}}"><input type="radio" name="criterio_5" id="criterio_5_{{$loop->iteration.'_'.$i}}"value="{{$i}}" @if ($i == 0) checked @endif required></td>
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td class="text-center">6</td>
                                                <td>Realiza sugerencias innovadoras para beneficio o mejora del programa en el que participa.</td>
                                                @for ($i = 0; $i < 5; $i++)
                                                <td class="text-center criterio{{$loop->iteration}}"><input type="radio" name="criterio_6" value="{{$i}}" @if ($i == 0) checked @endif required></td>
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td class="text-center">7</td>
                                                <td>Tiene iniciativa para ayudar en las actividades encomendadas y muestra espíritu de servicio.</td>
                                                @for ($i = 0; $i < 5; $i++)
                                                <td class="text-center criterio{{$loop->iteration}}"><input type="radio" name="criterio_7" value="{{$i}}" @if ($i == 0) checked @endif required></td>
                                                @endfor
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="observaciones">Observaciones:</label>
                                    <textarea id="observaciones" class="form-control" name="observaciones"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="col-sm-12 text-muted">Valor numérico de la actividad complementaria (Promedio de los criterios): <strong id="showValor{{$loop->iteration}}">0.00</strong></h5>
                            <input type="hidden" name="valor" id="valor{{$loop->iteration}}" value="0.00">
                        </div>
                    </form>
                    <div class="row">
                        <h5 class="col-sm-12 text-muted">Nivel de desempeño alcanzado de la actividad complementaria: <strong id="showNivel{{$loop->iteration}}">Insuficiente</strong></h5>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <a href="/responsable-actividad-complementaria/rubricas-alumno" class="btn btn-default btn-raised btn-sm">Atrás</a>
                    <button type="button" class="btn btn-primary btn-raised btn-sm" title="Calificar la rúbrica de evaluación" data-toggle="modal" data-target="#confirmarCalificar{{$loop->iteration}}">
                        <i class="fas fa-paste"></i>&nbsp;&nbsp;&nbsp;Calificar
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal del comentario --}}
    <div class="modal fade" id="modalComentario{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel{{$loop->iteration}}">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background: #03a9f4;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel{{$loop->iteration}}">Comentario</h4>
              <br>
            </div>
            <div class="modal-body">
                <h4>{{$actividad->comentario}}</h4>
            </div>
          </div>
        </div>
    </div>
    <!-- Modal de confirmación-->
    <div class="modal fade" id="confirmarCalificar{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">CONFIRMAR EVALUACIÓN</h4>
              <br>
            </div>
            <div class="modal-body">
                <div class="text-left m-3">
                    La evaluación será enviada a proyecto docencia, correspondiente al departamento del alumno y no podrá ser cambiada posteriormente.
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-raised" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary btn-raised" form="formCalificarRubrica{{$loop->iteration}}">
                <i class="far fa-check-circle"></i>&nbsp;&nbsp;&nbsp;Confirmar
              </button>
            </div>
          </div>
        </div>
    </div>
    <!-- Modal de rechazo -->
    <div class="modal fade" id="modalRechazar{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel{{$loop->iteration}}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #e57373">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel{{$loop->iteration}}">Rechazar la actividad complementaria del alumno</h4>
                    <br>
                </div>
                <div class="modal-body">
                    <p class="text-danger">*  Realiza un comentario para indicarle al alumno cual fue el motivo del rechazo</p>
                    <form action="{{ route('responsable.actividad.rechazar', ['alumno'=>$alumno->no_de_control]) }}" id="formRechazar{{$loop->iteration}}" method="post">
                        @csrf
                        <input type="hidden" name="actividad" value="{{$actividad->idRubrica}}">
                        <div class="form-group">
                            <label for="comentario">Comentario:</label>
                            <textarea id="comentario" class="form-control" name="comentario" rows="5"></textarea>
                        </div>
                    </form>  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-raised" data-dismiss="modal">Cerrar</button>
                    <button type="submit" form="formRechazar{{$loop->iteration}}" class="btn btn-danger btn-raised" title="Rechazar la actividad y enviar el comentario realizado al alumno">Rechazar</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
      
    {{-- Uso de JQuery --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    {{-- Script para el filtro de departamento de los responsables --}}
    <script src="{{ asset('js/evaluarRubricasAlumno.js') }}"></script>

@endsection

@section('errores')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <script>new PNotify({ title: 'Error', text: '{{ $error }}', type: 'error' });</script>
        @endforeach
    @endif
    @if (session('mensaje'))
        <script>new PNotify({ title: 'Confirmación', text: '{{session('mensaje')}}', type: 'success' });</script>
    @endif
@endsection