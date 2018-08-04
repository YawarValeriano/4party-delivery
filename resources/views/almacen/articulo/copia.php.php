@extends ('layouts.admin')
@section ('contenido')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Nombre</th>
					<th>Código</th>
					<th>Stock</th>
					<th>Categoria</th>
					<th>Descripción</th>
				</thead>
                @foreach($articulos as $art)
				<tr>
					<td>{{ $art->nombre }}</td>
					<td>{{ $art->codigo }}</td>
					<td>{{ $art->stock }}</td>
					<td>{{ $art->categoria }}</td>
					<td>{{ $art->descripcion }}</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>	
@endsection