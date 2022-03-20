@extends('layouts.'.$tipo)

@section('contenido')
<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title text-center">Cambiar contraseña</h3>
			</div>
			<form action="{{route('update.password')}}" method="post" id="form-agregar-credito">
				@csrf
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-1">
							<div class="panel-heading">
								<p class="panel-title" style="color: #343a40;">En seguida podrás cambiar tu contraseña actual del sistema, recuerda que debe tener 6 caracteres como mínimo, 1 número y 1 caracter especial.</p>
							</div>
							<br>

							<p class="text-danger">Los campos con * son obligatorios</p>

							<div class="form-group label-floating is-empty">
								<label for="current_password" class="control-label">Contraseña actual *</label>
								<input type="password" name="current_password" id="current_password" class="form-control" autocomplete="off">
							</div>

							<div class="form-group label-floating is-empty">
								<label for="new_password" class="control-label">Contraseña nueva *</label>
								<input type="password" name="new_password" id="new_password" class="form-control" autocomplete="off">
							</div>

							<div class="form-group label-floating is-empty">
								<label for="new_confirm_password" class="control-label">Repetir contraseña nueva *</label>
								<input type="password" name="new_confirm_password" id="new_confirm_password" class="form-control" autocomplete="off">
							</div>

						</div>
					</div>

				</div>
				<div class="panel-footer text-right">
					<a href="{{route('inicio')}}" class="btn btn-default btn-raised btn-sm">Cancelar</a>
					<button type="submit" class="btn btn-primary btn-raised btn-sm">Aceptar</button>
				</div>
			</form>

		</div>
	</div>
</div>
@endsection
@section('errores')
	@if (session('mensaje'))	
	    <script>new PNotify({ title: 'Confirmación', text: '{{ $mensaje }}', type: 'success' });</script>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <script>new PNotify({ title: 'Error', text: '{{ $error }}', type: 'error' });</script>
        @endforeach
    @endif
@endsection