@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<h3>Nueva Venta</h3>
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

{!!Form::open(array('url'=>'ventas/venta','method'=>'POST','autocomplete'=>'off'))!!}
{{Form::token()}}
<div class="row">
	<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
		<div class="form-group">
    		<label for="cliente">Cliente</label>
    		<select name="id_cliente" id="id_cliente" class="form-control selectpicker" data-live-search="true">
    			@foreach($personas as $persona)
    				<option value="{{$persona->id_persona}}">{{$persona->nombre}}</option>
    			@endforeach
    		</select>
    	</div>
	</div>
	<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
		<div class="form-group">
    		<label>Tipo de Actividad</label>
    		<input type="text" name="tipo_actividad" disabled value="Venta" class="form-control">
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
							<option value="{{$articulo->id_articulo}}_{{$articulo->stock}}_{{$articulo->precio_promedio}}">{{$articulo->articulo}}</option>
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
					<label for="stock">Stock</label>
					<input type="number" name="pstock" disabled id="pstock" class="form-control" placeholder="Stock">
				</div>
			</div>
			<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				<div class="form-group">
					<label for="p_venta">Precio de Venta</label>
					<input type="number" step="any" disabled name="pp_venta" id="pp_venta" class="form-control" placeholder="P. Venta">
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
						<th>Precio Venta</th>
						<th>Subtotal</th>
					</thead>
					<tfoot>
						<th>TOTAL</th>
						<th></th>
						<th></th>
						<th></th>
						<th><h4 id="total">Bs 0.00</h4> <input type="hidden" name="total_venta" id="total_venta"></th>
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
		$("#pid_articulo").change(mostrarValores);

		function mostrarValores(){
			datos=document.getElementById('pid_articulo').value.split('_');
			$("#pp_venta").val(datos[2]);
			$("#pstock").val(datos[1]);
		}
		function agregar(){
			datos=document.getElementById('pid_articulo').value.split('_');
			$("#pp_venta").val(datos[2]);

			id_articulo=datos[0];
			articulo=$("#pid_articulo option:selected").text();
			cantidad=parseInt($("#pcantidad").val());
			p_venta=$("#pp_venta").val();
			stock=parseInt($("#pstock").val());

			if(	id_articulo!="" && cantidad!="" && cantidad>0 && p_venta!=""){
				if(stock>=cantidad){
					subtotal[cont]=(cantidad*p_venta);
					total=total+subtotal[cont];

					var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+')">x</button></td><td><input type="hidden" name="id_articulo[]" value="'+id_articulo+'">'+articulo+'</td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input type="number" step="any" name="precio_venta[]" value="'+p_venta+'"></td><td>'+subtotal[cont]+'</td></tr>';
					cont=cont+1;
					limpiar();
					$("#total").html("Bs "+total);
					$("#total_venta").val(total);
					evaluar();
					$("#detalles").append(fila);
				}
				else{
					alert('La cantidad a vender supera el stock '+cantidad+'  '+stock);
				}
			}
			else{
				alert("Error al ingresar el detalle de la venta, revise los datos del artículo");
			}
		}
		function limpiar(){
			$("#pcantidad").val("");
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
			$("#total_venta").val(total);
			$("#fila"+index).remove();
			evaluar();
		}
	</script>
@endpush
@endsection