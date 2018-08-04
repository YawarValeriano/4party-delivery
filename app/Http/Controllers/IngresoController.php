<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\IngresoFormRequest;
use sisVentas\Ingreso;
use sisVentas\Ing_Arti;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
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
			$ingresos=DB::table('ingreso as i')
				->join('persona as p','i.id_proveedor','=','p.id_persona')
				->join('ing_arti as ia','i.id_ingreso','=','ia.id_ingreso')
				->select('i.id_ingreso','i.fecha_hora','p.nombre','i.tipo_actividad','i.num_comprobante','i.estado',DB::raw('sum(ia.cantidad*precio_compra) as total'))
				->where('i.num_comprobante','LIKE','%'.$query.'%')
				->orderBy('i.id_ingreso','desc')
				->groupBy('i.id_ingreso','i.fecha_hora','p.nombre','i.tipo_actividad','i.num_comprobante','i.estado')
				->paginate(7);
			return view('compras.ingreso.index',["ingresos"=>$ingresos,"searchText"=>$query]);
		}
	}
	public function ingreso_pdf()
	{
		$ingresos=DB::table('ingreso as i')
			->join('persona as p','i.id_proveedor','=','p.id_persona')
			->join('ing_arti as ia','i.id_ingreso','=','ia.id_ingreso')
			->select('i.id_ingreso','i.fecha_hora','p.nombre','i.tipo_actividad','i.num_comprobante','i.estado',DB::raw('sum(ia.cantidad*precio_compra) as total'))
			->orderBy('i.id_ingreso','desc')
			->groupBy('i.id_ingreso','i.fecha_hora','p.nombre','i.tipo_actividad','i.num_comprobante','i.estado');
		$pdf = \PDF::loadView('compras.ingreso.pdf_ingreso', compact('ingresos'));
        return $pdf->stream('Ingresos.pdf');
	}
	public function create()
	{
		$personas=DB::table('persona')->where('tipo_persona','=','Proveedor')->get();
		$articulos=DB::table('articulo as art')
			->select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'), 'art.id_articulo')
			->where('art.estado','=','Activo')
			->get();
		return view("compras.ingreso.create",["personas"=>$personas,"articulos"=>$articulos]);
	}
	public function store (IngresoFormRequest $request)
	{
		try {
			DB::beginTransaction();
			$ingreso=new Ingreso();
			$ingreso->id_proveedor=$request->get('id_proveedor');
			$ingreso->num_comprobante=$request->get('num_comprobante');
			$time = Carbon::now('America/La_Paz');
			$ingreso->fecha_hora=$time->toDateTimeString();
			$ingreso->estado='A';
			$ingreso->tipo_actividad='Compra';
			$ingreso->save();

			$id_articulo=$request->get('id_articulo');
			$cantidad=$request->get('cantidad');
			$p_compra=$request->get('precio_compra');
			$p_venta=$request->get('precio_venta');

			$cont=0;
			while ($cont < count($id_articulo)) {
				$detalle= new Ing_Arti;
				$detalle->id_ingreso=$ingreso->id_ingreso;
				$detalle->id_articulo=$id_articulo[$cont];
				$detalle->cantidad=$cantidad[$cont];
				$detalle->precio_compra=$p_compra[$cont];
				$detalle->precio_venta=$p_venta[$cont];
				$detalle->save();
				$cont=$cont+1;
			}
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
		}
		return Redirect::to('compras/ingreso');
	}
	public function show($id)
    {
    	$ingreso=DB::table('ingreso as i')
			->join('persona as p','i.id_proveedor','=','p.id_persona')
			->join('ing_arti as ia','i.id_ingreso','=','ia.id_ingreso')
			->select('i.id_ingreso','i.fecha_hora','p.nombre','i.tipo_actividad','i.num_comprobante','i.estado',DB::raw('sum(ia.cantidad*ia.precio_compra) as total'))
			->where('i.id_ingreso','=',$id)
			->groupBy('i.id_ingreso','i.fecha_hora','p.nombre','i.tipo_actividad','i.num_comprobante','i.estado')
			->first();

		$detalles=DB::table('ing_arti as ia')
			->join('articulo as a','ia.id_articulo','=','a.id_articulo')
			->select('a.nombre as articulo','ia.cantidad','ia.precio_compra','ia.precio_venta')
			->where('ia.id_ingreso','=',$id)
			->get();

        return view("compras.ingreso.show",["ingreso"=>$ingreso,"detalles"=>$detalles]); 
    }
   	public function destroy($id)
    {
        $ingreso=Ingreso::findOrFail($id);
        $ingreso->estado='C';
        $ingreso->update();
        return Redirect::to('compras/ingreso');
    }
}
