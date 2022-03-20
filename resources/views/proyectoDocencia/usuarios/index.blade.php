@extends('layouts.docencia')

@section('contenido')
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="table-responsive">
                <table class="table table-bordered table-striped default">
                    <thead>
                        <tr>
                            <th colspan="6">USUARIOS DE LA APLICACION</td>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Contraseña Default</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$usuario->usuario}}</td>
                            <td>{{$usuario->tipo}}</td>
                            <td class="text-left"> {{$usuario->nombre}}</td>
                            <td>{{$usuario->default}}</td>
                            <td class="m-1">
                                <button type="button" class="btn btn-danger fas fa-key" data-toggle="modal" 
                                    data-target="#restorePassword{{$usuario->id}}" title="Recuperar Contraseña Default">
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach ($usuarios as $usuario)
<div class="modal fade" id="restorePassword{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="restorePassword{{$usuario->id}}Label">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="restorePassword{{$usuario->id}}Label">RESTAURAR LA CONTRASEÑA DE DEFAULT</h4>
          <br>
        </div>
        <div class="modal-body">
            <form action="{{ route('usuarios.restorePassword') }}" method="POST" id="form-restore-password-{{$usuario->id}}">
                @csrf
                <input type="hidden" name="usuario" value="{{$usuario->id}}">
                <strong class="text-danger">
                    LA CONTRASEÑA DEFAULT DEL USUARIO SE CONVERTIRA EN SU CONTRASEÑA PARA ENTRAR A LA APLICACION
                </strong>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-raised" data-dismiss="modal">Cerrar</button>
          <button type="submit" form="form-restore-password-{{$usuario->id}}" class="btn btn-danger btn-raised">RESTAURAR</button>
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