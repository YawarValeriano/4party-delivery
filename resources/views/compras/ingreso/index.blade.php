@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Ingresos <a href="ingreso/create"><button class="btn btn-success">Nuevo</button></a>
		<a href="{{asset('/docs/Ingresos.pdf')}}" download="Ingresos.pdf"><button class="btn btn-info">Descargar Reporte</button></a>
		</h3>
		@include('compras.ingreso.search')
	</div>
</div>

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
					<th>Opciones</th>
				</thead>
                @foreach ($ingresos as $ing)
				<tr>
					<td>{{ $ing->fecha_hora}}</td>
					<td>{{ $ing->nombre}}</td>
					<td>{{ $ing->tipo_actividad.': '.$ing->num_comprobante}}</td>
					<td>{{ $ing->total}}</td>
					<td>{{ $ing->estado}}</td>
					<td>
						<a href="{{URL::action('IngresoController@show', $ing->id_ingreso)}}"><button class="btn btn-primary">Detalles</button></a>
                         <a href="" data-target="#modal-delete-{{$ing->id_ingreso}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
                         <a href="{{asset('/docs/rep_ingreso_8.pdf')}}" download="Reporte_Ingreso_{{$ing->id_ingreso}}_detalle.pdf"><button class="btn btn-info">Reporte</button></a>
					</td>
				</tr>
				@include('compras.ingreso.modal')
				@endforeach
			</table>
		</div>
		{{$ingresos->render()}}
	</div>
</div>	
@endsection