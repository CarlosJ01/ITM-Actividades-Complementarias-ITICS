@extends('layouts.docencia')

@section('contenido')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">EVALUACIÓN AL DESEMPEÑO DE LA ACTIVIDAD COMPLEMENTARIA</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <h5 class="col-sm-8 text-muted">Nombre del alumno: <strong>{{$datosRubrica['nombreAlumno']}}</strong></h5>
                        <h5 class="col-sm-4 text-muted">No. De Control: <strong>{{$datosRubrica['numeroControl']}}</strong></h5>
                    </div>
                    <div class="row">
                        <h5 class="col-sm-12 text-muted">Nombre del responsable de la actividad: <strong>{{$datosRubrica['nombreResponsable']}}</strong></h5>
                    </div>
                    <div class="row">
                        <h5 class="col-sm-12 text-muted">Actividad complementaria: <strong>{{$datosRubrica['actividad']}}</strong></h5>
                    </div>
                    <div class="row">
                        <h5 class="col-sm-12 text-muted">Periodo de realización: <strong>{{$datosRubrica['periodo']}}</strong></h5>
                    </div>
                    <br>
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
                                            <td class="text-center"><input type="radio" name="criterio_1" value="{{$i}}" @if ($rubrica->criterio_1 == $i) checked @else disabled @endif></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td>Trabaja en equipo y se adapta a nuevas situaciones.</td>
                                            @for ($i = 0; $i < 5; $i++)
                                            <td class="text-center"><input type="radio" name="criterio_2" value="{{$i}}" @if ($rubrica->criterio_2 == $i) checked @else disabled @endif></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td>Muestra liderazgo en las actividades encomendadas.</td>
                                            @for ($i = 0; $i < 5; $i++)
                                            <td class="text-center"><input type="radio" name="criterio_3" value="{{$i}}" @if ($rubrica->criterio_3 == $i) checked @else disabled @endif></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="text-center">4</td>
                                            <td>Organiza su tiempo y trabaja de manera proactiva.</td>
                                            @for ($i = 0; $i < 5; $i++)
                                            <td class="text-center"><input type="radio" name="criterio_4" value="{{$i}}" @if ($rubrica->criterio_4 == $i) checked @else disabled @endif></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="text-center">5</td>
                                            <td>Interpreta la realidad y se sensibiliza aportando soluciones a la problemática con la actividad complementaria.</td>
                                            @for ($i = 0; $i < 5; $i++)
                                            <td class="text-center"><input type="radio" name="criterio_5" value="{{$i}}" @if ($rubrica->criterio_5 == $i) checked @else disabled @endif></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="text-center">6</td>
                                            <td>Realiza sugerencias innovadoras para beneficio o mejora del programa en el que participa.</td>
                                            @for ($i = 0; $i < 5; $i++)
                                            <td class="text-center"><input type="radio" name="criterio_6" value="{{$i}}" @if ($rubrica->criterio_6 == $i) checked @else disabled @endif></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="text-center">7</td>
                                            <td>Tiene iniciativa para ayudar en las actividades encomendadas y muestra espíritu de servicio.</td>
                                            @for ($i = 0; $i < 5; $i++)
                                            <td class="text-center"><input type="radio" name="criterio_7" value="{{$i}}" @if ($rubrica->criterio_7 == $i) checked @else disabled @endif></td>
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
                                @if ($rubrica->observaciones == null)
                                    <textarea id="observaciones" class="form-control" name="observaciones" rows="1" readonly></textarea>
                                @else
                                    <textarea id="observaciones" class="form-control" name="observaciones" readonly>{{$rubrica->observaciones}}</textarea>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h5 class="col-sm-12 text-muted">Valor numérico de la actividad complementaria (Promedio de los criterios): <strong>{{$rubrica->valor}}</strong></h5>
                    </div>
                    <div class="row">
                        <h5 class="col-sm-12 text-muted">Nivel de desempeño alcanzado de la actividad complementaria: <strong>{{$rubrica->desempenio}}</strong></h5>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <a href="{{ route('docencia.expediente.alumno', ['numeroControl' => $numeroControl]) }}" class="btn btn-default btn-raised btn-sm">Atrás</a>
                </div>
            </div>
        </div>
    </div>
@endsection