@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Proveedores <a href="proveedor/create"><button class="btn btn-success">Nuevo</button></a></h3>
		@include('compras.proveedor.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Nombre</th>
					<th>Telefono</th>
					<th>Dirección</th>
					<th>Email</th>
					<th>Opciones</th>
				</thead>
                @foreach ($personas as $per)
				<tr>
					<td>{{ $per->nombre}}</td>
					<td>{{ $per->telefono}}</td>
					@if($per->direccion != '')
						<td>{{ $per->direccion}}</td>
					@else
						<td>No existe</td>
					@endif
					<td>{{ $per->email}}</td>
					<td>
						<a href="{{URL::action('ProveedorController@edit', $per->id_persona)}}"><button class="btn btn-info">Editar</button></a>
                         <a href="" data-target="#modal-delete-{{$per->id_persona}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
					</td>
				</tr>
				@include('compras.proveedor.modal')
				@endforeach
			</table>
		</div>
		{{$personas->render()}}
	</div>
</div>	
@endsection