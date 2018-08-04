@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<h3>Nuevo Ingreso</h3>
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

{!!Form::open(array('url'=>'compras/ingreso','method'=>'POST','autocomplete'=>'off'))!!}
{{Form::token()}}
<div class="row">
	<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
		<div class="form-group">
    		<label for="proveedor">Proveedor</label>
    		<select name="id_proveedor" id="id_proveedor" class="form-control selectpicker" data-live-search="true">
    			@foreach($personas as $persona)
    				<option value="{{$persona->id_persona}}">{{$persona->nombre}}</option>
    			@endforeach
    		</select>
    	</div>
	</div>
	<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
		<div class="form-group">
    		<label>Tipo de Actividad</label>
    		<input type="text" name="tipo_actividad" class="form-control" disabled value="Compra">
    	</div>
	</div>
	<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
		<div class="form-group">
    		<label for="num_comprobante">Número Comprobante</label>
    		<input type="numbrer" name="num_comprobante" required value="{{old('num_comprobante')}}" class="form-control" placeholder="Número Comprobante...">
    	</div>
	</div>
</div>
<div class="row">
	<div class="panel panel-primary">
		<div class="panel-body">
			<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				<div class="form-group">
					<label>Artículo</label>
					<select name="pid_articulo" class="form-control selectpicker" id="pid_articulo" data-live-search="true">
						@foreach($articulos as $articulo)
							<option value="{{$articulo->id_articulo}}">{{$articulo->articulo}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				<div class="form-group">
					<label for="cantidad">Cantidad</label>
					<input type="number" name="cantidad" id="pcantidad" class="form-control" placeholder="Cantidad">
				</div>
			</div>
			<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				<div class="form-group">
					<label for="p_compra">Precio de Compra</label>
					<input type="number" step="any" name="pp_compra" id="pp_compra" class="form-control" placeholder="P. Compra">
				</div>
			</div>
			<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				<div class="form-group">
					<label for="p_venta">Precio de Venta</label>
					<input type="number" step="any" name="pp_venta" id="pp_venta" class="form-control" placeholder="P. Venta">
				</div>
			</div>
			<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				<div class="form-group">
					<button type="button" id="bt_add" class="btn btn-primary">Agregar</button>	
				</div>
			</div>
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
				<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
					<thead style="background-color: #A9D0F5">
						<th>Opciones</th>
						<th>Artículo</th>
						<th>Cantidad</th>
						<th>Precio Compra</th>
						<th>Precio Venta</th>
						<th>Subtotal</th>
					</thead>
					<tfoot>
						<th>TOTAL</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th><h4 id="total">Bs 0.00</h4></th>
					</tfoot>	
					<tbody>
						
					</tbody>
				</table>
			</div>

		</div>	
	</div>
	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">
		<div class="form-group">
			<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
        	<button class="btn btn-primary" type="submit">Guardar</button>
	    	<button class="btn btn-warning" type="reset">Limpiar campos</button>
    	</div>
	</div>
</div>
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
	<div class="form-group">
		<a href="{{ URL::previous() }}" class="btn btn-danger">Volver sin Guardar</a>
	</div>
</div>
{!!Form::close()!!}		
@push('scripts')
	<script>
		$(document).ready(function(){
			$('#bt_add').click(function(){
				agregar();
			});
		});

		var cont=0;
		total=0;
		subtotal=[];
		$("#guardar").hide();

		function agregar(){
			id_articulo=$("#pid_articulo").val();
			articulo=$("#pid_articulo option:selected").text();
			cantidad=$("#pcantidad").val();
			p_compra=$("#pp_compra").val();
			p_venta=$("#pp_venta").val();

			if(	id_articulo!="" && cantidad!="" && cantidad>0 && p_compra!="" && p_venta!=""){
				subtotal[cont]=(cantidad*p_compra);
				total=total+subtotal[cont];

				var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+')">x</button></td><td><input type="hidden" name="id_articulo[]" value="'+id_articulo+'">'+articulo+'</td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input type="number" step="any" name="precio_compra[]" value="'+p_compra+'"></td><td><input type="number" step="any" name="precio_venta[]" value="'+p_venta+'"></td><td>'+subtotal[cont]+'</td></tr>';
				cont=cont+1;
				limpiar();
				$("#total").html("Bs "+total);
				evaluar();
				$("#detalles").append(fila);
			}
			else{
				alert("Error al ingresar el detalle del ingreso, revise los datos del artículo");
			}
		}
		function limpiar(){
			$("#pcantidad").val("");
			$("#pp_compra").val("");
			$("#pp_venta").val("");
		}
		function evaluar(){
			if(total>0){
				$("#guardar").show();
			}
			else{
				$("#guardar").hide();
			}
		}
		function eliminar(index){
			total=total-subtotal[index];
			$("#total").html("Bs "+total);
			$("#fila"+index).remove();
			evaluar();
		}
	</script>
@endpush
@endsection