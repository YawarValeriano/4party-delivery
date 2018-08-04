@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Usuario: {{ $usuario->name}}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::model($usuario,['method'=>'PATCH','route'=>['usuario.update',$usuario->id]])!!}
            {{Form::token()}}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	            <label for="name" class="col-md-4 control-label">Nombre</label>
	            <div class="col-md-6">
	                <input id="name" type="text" class="form-control" name="name" value="{{$usuario->name}}" disabled>
	            </div>
	        </div>

	        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	            <label for="email" class="col-md-4 control-label">E-Mail</label>
	            <div class="col-md-6">
	                <input id="email" type="email" class="form-control" name="email" value="{{ $usuario->email }}" required>
	                @if ($errors->has('email'))
	                    <span class="help-block">
	                        <strong>{{ $errors->first('email') }}</strong>
	                    </span>
	                @endif
	            </div>
	        </div>

	        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	            <label for="password" class="col-md-4 control-label">Nueva Contraseña</label>
	            <div class="col-md-6">
	                <input id="password" type="password" class="form-control" name="password" required autofocus>
	                @if ($errors->has('password'))
	                    <span class="help-block">
	                        <strong>{{ $errors->first('password') }}</strong>
	                    </span>
	                @endif
	            </div>
	        </div>

	        <div class="form-group">
	            <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>
	            <div class="col-md-6">
	                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
	            </div>
	        </div>
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<a href="{{ URL::previous() }}" class="btn btn-danger">Cancelar</a>
            </div>

			{!!Form::close()!!}		
            
		</div>
	</div>
@endsection