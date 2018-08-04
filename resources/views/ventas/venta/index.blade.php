@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Ventas <a href="venta/create"><button class="btn btn-success">Nuevo</button></a>
		<a href="{{asset('/docs/Ventas.pdf')}}" download="Ventas.pdf"><button class="btn btn-info">Descargar Reporte</button></a>
		</h3>
		@include('ventas.venta.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Fecha</th>
					<th>Cliente</th>
					<th>Comprobante</th>
					<th>Total</th>
					<th>Estado</th>
					<th>Opciones</th>
				</thead>
                @foreach ($ventas as $ven)
				<tr>
					<td>{{ $ven->fecha_hora}}</td>
					<td>{{ $ven->nombre}}</td>
					<td>{{ $ven->tipo_actividad.': '.$ven->num_comprobante}}</td>
					<td>{{ $ven->total_venta}}</td>
					<td>{{ $ven->estado}}</td>
					<td>
						<a href="{{URL::action('VentaController@show', $ven->id_venta)}}"><button class="btn btn-primary">Detalles</button></a>
                         <a href="" data-target="#modal-delete-{{$ven->id_venta}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
                         <a href="{{asset('/docs/rep_venta_3.pdf')}}" download="Reporte_Venta_{{$ven->id_venta}}_detalle.pdf"><button class="btn btn-info">Reporte</button></a>
					</td>
				</tr>
				@include('ventas.venta.modal')
				@endforeach
			</table>
		</div>
		{{$ventas->render()}}
	</div>
</div>	
@endsection