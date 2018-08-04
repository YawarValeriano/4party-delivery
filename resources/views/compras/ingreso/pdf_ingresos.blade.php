@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Fecha</th>
					<th>Proveedor</th>
					<th>Comprobante</th>
					<th>Total</th>
					<th>Estado</th>
				</thead>
                @foreach ($ingresos as $ing)
				<tr>
					<td>{{ $ing->fecha_hora}}</td>
					<td>{{ $ing->nombre}}</td>
					<td>{{ $ing->tipo_actividad.': '.$ing->num_comprobante}}</td>
					<td>{{ $ing->total}}</td>
					<td>{{ $ing->estado}}</td>
					
				</tr>
				@endforeach
			</table>
		</div>
		
	</div>
</div>	
@endsection