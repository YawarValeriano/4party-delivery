@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<h3>Editar Proveedor: {{ $persona->nombre}}</h3>
		@if (count($errors)>0)
		<div class="alert alert-danger">
			<ul>
			@foreach ($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
			</ul>
		</div>
		@endif
	</div>
</div>
{!!Form::model($persona,['method'=>'PATCH','route'=>['proveedor.update',$persona->id_persona]])!!}
{{Form::token()}}
<div class="row">
	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		<div class="form-group">
    		<label for="nombre">Nombre</label>
    		<input type="text" name="nombre" required value="{{$persona->nombre}}" class="form-control" placeholder="Nombre...">
    	</div>
	</div>
	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		<div class="form-group">
    		<label for="direccion">Dirección</label>
    		<input type="text" name="direccion" value="{{$persona->direccion}}" class="form-control" placeholder="Dirección...">
    	</div>
	</div>
	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		<div class="form-group">
    		<label for="telefono">Teléfono</label>
    		<input type="text" name="telefono" value="{{$persona->telefono}}" class="form-control" placeholder="Telefono...">
    	</div>
	</div>
	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		<div class="form-group">
    		<label for="codigo">Email</label>
    		<input type="email" name="email" required value="{{$persona->email}}" class="form-control" placeholder="Email...">
    	</div>
	</div>
	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		<div class="form-group">
        	<button class="btn btn-primary" type="submit">Guardar</button>
    		<a href="{{ URL::previous() }}" class="btn btn-danger">Cancelar</a>
    	</div>
	</div>
</div>
{!!Form::close()!!}		
        
@endsection