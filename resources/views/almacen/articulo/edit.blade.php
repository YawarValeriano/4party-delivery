@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<h3>Editar Artículo: {{ $articulo->nombre}}</h3>
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
{!!Form::model($articulo,['method'=>'PATCH','route'=>['articulo.update',$articulo->id_articulo],'files'=>'true'])!!}
{{Form::token()}}
<div class="row">
	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		<div class="form-group">
    		<label for="nombre">Nombre</label>
    		<input type="text" name="nombre" required value="{{$articulo->nombre}}" class="form-control" >
    	</div>
	</div>
	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		<div class="form-group">
			<label>Categoria</label>
			<select name="id_categoria" class="form-control">
				@foreach ($categorias as $cat)
					@if ($cat->id_categoria == $articulo->id_categoria)
						<option value="{{$cat->id_categoria}}" selected>{{$cat->nombre}}</option>
					@else
						<option value="{{$cat->id_categoria}}">{{$cat->nombre}}</option>
					@endif
				@endforeach
			</select>
		</div>
	</div>
	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		<div class="form-group">
    		<label for="codigo">Código</label>
    		<input type="text" name="codigo" required value="{{$articulo->codigo}}" class="form-control">
    	</div>
	</div>
	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		<div class="form-group">
    		<label for="stock">Stock</label>
    		<input type="text" name="stock" required value="{{$articulo->stock}}" class="form-control">
    	</div>
	</div>
	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		<div class="form-group">
    		<label for="descripcion">Descripción</label>
    		<input type="text" name="descripcion" value="{{$articulo->descripcion}}" class="form-control" placeholder="Descripción del articulo...">
    	</div>
	</div>
	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		<div class="form-group">
    		<label for="imagen">Imagen</label>
    		<input type="file" name="imagen" class="form-control">
    		@if(($articulo->imagen)!="")
    			<img src="{{asset('imagenes/articulos/'.$articulo->imagen)}}">
    		@endif
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