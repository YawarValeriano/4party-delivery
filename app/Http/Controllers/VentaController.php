<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use sisVentas\Http\Requests;


use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\VentaFormRequest;
use sisVentas\Venta;
use sisVentas\Vent_Art;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class VentaController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}
	public function index(Request $request)
	{
		if($request)
		{
			$query=trim($request->get('searchText'));
			$ventas=DB::table('venta as v')
				->join('persona as p','v.id_cliente','=','p.id_persona')
				->join('vent_art as va','v.id_venta','=','va.id_venta')
				->select('v.id_venta','v.fecha_hora','p.nombre','v.tipo_actividad','v.num_comprobante','v.estado','v.total_venta')
				->where('v.num_comprobante','LIKE','%'.$query.'%')
				->orderBy('v.id_venta','desc')
				->groupBy('v.id_venta','v.fecha_hora','p.nombre','v.tipo_actividad','v.num_comprobante','v.estado','v.total_venta')
				->paginate(7);
			return view('ventas.venta.index',["ventas"=>$ventas,"searchText"=>$query]);
		}
	}
	public function create()
	{
		$personas=DB::table('persona')->where('tipo_persona','=','Cliente')->get();
		$articulos=DB::table('articulo as art')
			->join('ing_arti as va','art.id_articulo','=','va.id_articulo')
			->select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.id_articulo','art.stock',DB::raw('avg(va.precio_venta) as precio_promedio'))
			->where('art.estado','=','Activo')
			->where('art.stock','>','0')
			->groupBy('articulo','art.id_articulo','art.stock')
			->get();
		return view("ventas.venta.create",compact("personas","articulos"));
	}
	public function venta_pdf(){
		$ventas=DB::table('venta as v')
			->join('persona as p','v.id_cliente','=','p.id_persona')
			->join('vent_art as va','v.id_venta','=','va.id_venta')
			->select('v.id_venta','v.fecha_hora','p.nombre','v.tipo_actividad','v.num_comprobante','v.estado','v.total_venta')
			->orderBy('v.id_venta','desc')
			->groupBy('v.id_venta','v.fecha_hora','p.nombre','v.tipo_actividad','v.num_comprobante','v.estado','v.total_venta');
		$pdf = \PDF::loadView('ventas.venta.pdf_ventas', compact('ventas'));
        return $pdf->stream('Ingresos.pdf');
	}
	public function store (VentaFormRequest $request)
	{
		try {
			DB::beginTransaction();
			$venta=new Venta;
			$venta->id_cliente=$request->get('id_cliente');
			$venta->tipo_actividad='Venta';
			$venta->num_comprobante=$request->get('num_comprobante');
			$venta->total_venta=$request->get('total_venta');
			$venta->id_user=Auth::user()->id;

			$time = Carbon::now('America/La_Paz');
			$venta->fecha_hora=$time->toDateTimeString();
			$venta->estado='A';
			$venta->save();

			$id_articulo=$request->get('id_articulo');
			$cantidad=$request->get('cantidad');
			$p_venta=$request->get('precio_venta');

			$cont=0;
			
			while ($cont < count($id_articulo)) {
				$detalle= new Vent_Art();
				$detalle->id_venta=$venta->id_venta;
				$detalle->id_articulo=$id_articulo[$cont];
				$detalle->cantidad=$cantidad[$cont];
				$detalle->precio_venta=$p_venta[$cont];
				$detalle->save();
				$cont=$cont+1;
			}
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
		}
		return Redirect::to('ventas/venta');
	}
	public function show($id)
    {
    	$venta=DB::table('venta as v')
			->join('persona as p','v.id_cliente','=','p.id_persona')
			->join('vent_art as va','v.id_venta','=','va.id_venta')
			->select('v.id_venta','v.fecha_hora','p.nombre','v.tipo_actividad','v.num_comprobante','v.estado','v.total_venta')
			->where('v.id_venta','=',$id)
			->groupBy('v.id_venta','v.fecha_hora','p.nombre','v.tipo_actividad','v.num_comprobante','v.estado','v.total_venta')
			->first();

		$detalles=DB::table('vent_art as va')
			->join('articulo as a','va.id_articulo','=','a.id_articulo')
			->select('a.nombre as articulo','va.cantidad','va.precio_venta')
			->where('va.id_venta','=',$id)
			->get();

        return view("ventas.venta.show",["venta"=>$venta,"detalles"=>$detalles]); 
    }
   	public function destroy($id)
    {
        $venta=Venta::findOrFail($id);
        $venta->estado='C';
        $venta->update();
        return Redirect::to('ventas/venta');
    }
}
