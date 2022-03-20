@extends('layouts.alumno')

@section('contenido')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">PROPORCIONE LA INFORMACIÓN DE LA ACTIVIDAD COMPLEMENTARIA</h3>
                </div>
                <div class="panel-body">
                    <h4>Crédito complementario seleccionado: </h4>
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
                                            <td class="text-center">{{$credito->numero}}</td>
                                            <td>{{$credito->descripcion}}</td>
                                            <td class="text-center">{{$credito->valor}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ route('alumno.registrar.credito') }}" method="post" id="form-agregar-credito">
                        @csrf
                        <input type="hidden" name="id_credito_complementario" value="{{$credito->id}}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label for="fecha_inicio" class="control-label">Fecha de inicio</label> 
                                    <input type="text" name="fecha_inicio" id="fecha_inicio" class="form-control date-picker" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label for="fecha_fin" class="control-label">Fecha de término</label> 
                                    <input type="text" name="fecha_fin" id="fecha_fin" class="form-control date-picker" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <p class="text-danger">* Si la duración de la actividad fue entre meses seleccione el primer y último día del mes respectivo.</p>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group label-floating is-empty">
                                    <label for="enlace_evidencia" class="control-label">Enlace compartido del documento PDF de la evidencia de la actividad</label> 
                                    <input type="url" name="enlace_evidencia" id="enlace_evidencia" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <p class="text-danger">* El documento deberá ser de tipo PDF y estar subido en una plataforma de almacenamiento (One Drive, Drive, Mega, etc)</p>
                        <p class="text-danger">* El enlace deberá de ser compartido</p>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label for="departamento_responsable" class="control-label">Departamento del responsable de la actividad</label> 
                                    <select id="departamento_responsable" class="form-control" required>
                                        <option value=""></option>
                                        <option value="0">Todos los departamentos</option>
                                        @foreach ($departamentos as $departamento)
                                        <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label for="id_responsable" class="control-label">Responsable de la actividad complementaria</label>
                                    <select name="id_responsable" id="id_responsable" class="form-control" required>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <p class="text-danger">* Si no conoce al responsable de la actividad, seleccione a su tutor</p>
                    </form>
                    <form action="{{ route('alumno.agregar.credito.seleccion') }}" method="post" id="form-regresar">
                        @csrf
                        <input type="hidden" name="credito" value="{{$credito->id}}">
                    </form>
                </div>
                <div class="panel-footer text-right">
                    <button type="submit" class="btn btn-default btn-raised m-1" form="form-regresar">Atrás</button>
                    <button type="submit" id="registrarCredito" class="btn btn-primary btn-raised m-1" form="form-agregar-credito" title="Registrar el crédito complementario y enviarlo a revisión por el responsable de la actividad">
                        <i class="far fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Uso de JQuery --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    {{-- Script para el filtro de departamento de los responsables --}}
    <script src="{{ asset('js/agregarCredito.js') }}"></script>
@endsection

@section('errores')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <script>new PNotify({ title: 'Error', text: '{{ $error }}', type: 'error' });</script>
        @endforeach
    @endif
@endsection