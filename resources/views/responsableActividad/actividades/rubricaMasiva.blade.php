@extends('layouts.responsable')

@section('contenido')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">EVALUACIÓN AL DESEMPEÑO DE LA ACTIVIDAD COMPLEMENTARIA</h3>
                </div>
                <div class="panel-body">
                    <h4>Alumnos</h4>
                    <hr>
                    @foreach ($alumnos as $alumno)
                        <div class="row">
                            <h5 class="col-sm-9 text-muted">Nombre del alumno: <strong>{{$alumno->nombre.' '.$alumno->apellido_paterno.' '.($alumno->apellido_materno ? $alumno->apellido_materno : '')}}</strong></h5>
                            <h5 class="col-sm-3 text-muted">No. De Control: <strong>{{$alumno->no_de_control}}</strong></h5>
                        </div>
                    @endforeach
                    <hr>
                    <div class="row">
                        <h5 class="col-sm-9 text-muted">Actividad complementaria: <strong>{{$actividad->descripcion}}</strong></h5>
                        <h5 class="col-sm-3 text-muted">valor: <strong>{{$actividad->valor}}</strong></h5>
                    </div>
                    <br>
                    <form action="{{ route('responsable.calificar.rubricas.masivamente')}}" method="post" id="formCalificarRubricas">
                        @csrf
                        <input type="hidden" name="actividad" value="{{$actividad->id}}">
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
                                                <td class="text-center criterio"><input type="radio" name="criterio_1" value="{{$i}}" @if ($i == 0) checked @endif required></td>
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td>Trabaja en equipo y se adapta a nuevas situaciones.</td>
                                                @for ($i = 0; $i < 5; $i++)
                                                <td class="text-center criterio"><input type="radio" name="criterio_2" value="{{$i}}" @if ($i == 0) checked @endif required></td>
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td>Muestra liderazgo en las actividades encomendadas.</td>
                                                @for ($i = 0; $i < 5; $i++)
                                                <td class="text-center criterio"><input type="radio" name="criterio_3" value="{{$i}}" @if ($i == 0) checked @endif required></td>
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td class="text-center">4</td>
                                                <td>Organiza su tiempo y trabaja de manera proactiva.</td>
                                                @for ($i = 0; $i < 5; $i++)
                                                <td class="text-center criterio"><input type="radio" name="criterio_4" value="{{$i}}" @if ($i == 0) checked @endif required></td>
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td class="text-center">5</td>
                                                <td>Interpreta la realidad y se sensibiliza aportando soluciones a la problemática con la actividad complementaria.</td>
                                                @for ($i = 0; $i < 5; $i++)
                                                <td class="text-center criterio"><input type="radio" name="criterio_5" value="{{$i}}" @if ($i == 0) checked @endif required></td>
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td class="text-center">6</td>
                                                <td>Realiza sugerencias innovadoras para beneficio o mejora del programa en el que participa.</td>
                                                @for ($i = 0; $i < 5; $i++)
                                                <td class="text-center criterio"><input type="radio" name="criterio_6" value="{{$i}}" @if ($i == 0) checked @endif required></td>
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td class="text-center">7</td>
                                                <td>Tiene iniciativa para ayudar en las actividades encomendadas y muestra espíritu de servicio.</td>
                                                @for ($i = 0; $i < 5; $i++)
                                                <td class="text-center criterio"><input type="radio" name="criterio_7" value="{{$i}}" @if ($i == 0) checked @endif required></td>
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
                            <h5 class="col-sm-12 text-muted">Valor numérico de la actividad complementaria (Promedio de los criterios): <strong id="showValor">0.00</strong></h5>
                            <input type="hidden" name="valor" id="valor" value="0.00">
                        </div>
                    </form>
                    <div class="row">
                        <h5 class="col-sm-12 text-muted">Nivel de desempeño alcanzado de la actividad complementaria: <strong id="showNivel">Insuficiente</strong></h5>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <a href="{{ route('responsable.actividad', ['actividad'=>$actividad->id]) }}" class="btn btn-default btn-raised btn-sm">Atrás</a>
                    <button type="button" class="btn btn-primary btn-raised btn-sm" title="Calificar las rúbricas de evaluación" data-toggle="modal" data-target="#confirmarCalificar">
                        <i class="fas fa-paste"></i>&nbsp;&nbsp;&nbsp;Calificar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmarCalificar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">CONFIRMAR EVALUACIÓN</h4>
            <br>
            </div>
            <div class="modal-body">
                <div class="text-left m-3">
                    La evaluación se aplicara a todos los alumnos en la actividad complementaria, se enviara al proyecto docencia del respectivo departamento y no se podrán cambiar posteriormente.
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default btn-raised" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary btn-raised" form="formCalificarRubricas">
                <i class="far fa-check-circle"></i>&nbsp;&nbsp;&nbsp;Confirmar
            </button>
            </div>
        </div>
        </div>
    </div>

    {{-- Uso de JQuery --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    {{-- Script para el filtro de departamento de los responsables --}}
    <script src="{{ asset('js/evaluarRubrica.js') }}"></script>
@endsection

@section('errores')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <script>new PNotify({ title: 'Error', text: '{{ $error }}', type: 'error' });</script>
        @endforeach
    @endif
@endsection