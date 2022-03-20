@extends('layouts.alumno')

@section('contenido')
    @if ($actividad->edicion == 1)
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">EDITAR INFORMACIÓN DE LA ACTIVIDAD COMPLEMENTARIA</h3>
                </div>
                <div class="panel-body">
                    <h4>Crédito complementario registrado: </h4>
                    <br>
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped default">
                                    <thead>
                                        <tr>
                                            <th>Numero</th>
                                            <th>Descripción</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">{{$actividad->creditoComplementario->numero}}</td>
                                            <td>{{$actividad->creditoComplementario->descripcion}}</td>
                                            <td class="text-center">{{$actividad->creditoComplementario->valor}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($actividad->estatus == 2)
                            <form action="{{ route('alumno.actividad.cambiar.editar') }}" method="post">
                                @csrf
                                <input type="hidden" name="actividad" value="{{$actividad->id}}">
                                <div class="col-sm-12 text-right">
                                    <button type="submit" class="btn btn-warning btn-raised m-1" title="Cambiar la actividad registrada por otra" style="color: black">
                                        <i class="fas fa-exchange-alt"></i>&nbsp;&nbsp;&nbsp;Cambiar la actividad registrada
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                    <hr>
                    <form action="{{ route('alumno.update.actividad') }}" method="post" id="form-editar-actividad">
                        @csrf
                        <input type="hidden" name="actividad" value="{{$actividad->id}}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group label-floating">
                                    <label for="fecha_inicio" class="control-label">Fecha de inicio</label> 
                                    <input type="text" name="fecha_inicio" id="fecha_inicio" class="form-control date-picker" value="{{$actividad->fecha_inicio}}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group label-floating">
                                    <label for="fecha_fin" class="control-label">Fecha de término</label> 
                                    <input type="text" name="fecha_fin" id="fecha_fin" class="form-control date-picker" value="{{$actividad->fecha_fin}}" required>
                                </div>
                            </div>
                        </div>
                        <p class="text-danger">* Si la duración de la actividad fue entre meses seleccione el primer y último día del mes respectivo.</p>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group label-floating">
                                    <label for="enlace_evidencia" class="control-label">Enlace compartido del documento PDF de la evidencia de la actividad</label> 
                                    <input type="url" name="enlace_evidencia" id="enlace_evidencia" class="form-control" value="{{$actividad->enlace_evidencia}}" required>
                                </div>
                            </div>
                        </div>
                        <p class="text-danger">* El documento deberá ser de tipo PDF y estar subido en una plataforma de almacenamiento (One Drive, Drive, Mega, etc)</p>
                        <p class="text-danger">* El enlace deberá de ser compartido</p>
                        <br>
                        @if ($actividad->estatus == '2')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="departamento_responsable" class="control-label">Departamento del responsable de la actividad</label> 
                                    <select id="departamento_responsable" class="form-control" required>
                                        <option value="0">Todos los departamentos</option>
                                        @foreach ($departamentos as $departamento)
                                        <option value="{{$departamento->id}}" @if ($departamento->id == $actividad->rubricaEvaluacion->responsable->departamento->id) selected @endif>{{$departamento->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" id="divResponsable">
                                    <label for="id_responsable" class="control-label">Responsable de la actividad complementaria</label>
                                    <select name="id_responsable" id="id_responsable" class="form-control" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <p class="text-danger">* Si no conoce al responsable de la actividad, seleccione a su tutor</p>
                        @endif
                    </form>
                </div>
                <div class="panel-footer text-right">
                    <a href="{{ route('alumno.expediente') }}" class="btn btn-default btn-raised m-1">Atrás</a>
                    <button type="submit" id="editarCredito" class="btn btn-warning btn-raised m-1" form="form-editar-actividad" style="color: black" title="Actualizar la información de la actividad y volver a mandarla a revisión">
                        <i class="far fa-save"></i>&nbsp;&nbsp;&nbsp;Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Uso de JQuery --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    {{-- Script para el filtro de departamento de los responsables --}}
    <input type="hidden" id="idResponsable" value="{{$actividad->rubricaEvaluacion->responsable->id}}">
    <script src="{{ asset('js/editarActividad.js') }}"></script>
    @endif

    @if ($actividad->edicion == 2 && $actividad->estatus == 2)
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">SELECCIONE UNA NUEVA ACTVIDAD COMPLEMENTARIA</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('alumno.update.actividad.credito') }}" id="formEditarCredito" method="post">
                        @csrf
                        <input type="hidden" name="actividad" value="{{$actividad->id}}">
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
                <form action="{{ route('alumno.actividad.cambiar.editar') }}" method="post" id="cambiar-modo-edicion">
                    @csrf
                    <input type="hidden" name="actividad" value="{{$actividad->id}}">
                </form>
                <div class="panel-footer text-right">
                    <a href="{{ route('alumno.expediente') }}" class="btn btn-default btn-raised m-1">Atrás</a>
                    <button type="submit" form="cambiar-modo-edicion" class="btn btn-warning btn-raised m-1" title="Cambiar la informacion complementaria de la actividad" style="color: black">
                        <i class="fas fa-exchange-alt"></i>&nbsp;&nbsp;&nbsp;Cambiar Informacion Complementaria
                    </button>
                    @if(count($creditos) > 0)
                        <button type="submit" form="formEditarCredito" class="btn btn-warning btn-raised m-1" style="color: black" title="Actualizar el crédito complementario registrado">
                            <i class="far fa-save"></i>&nbsp;&nbsp;&nbsp;Actualizar
                        </button>
                    @endif
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