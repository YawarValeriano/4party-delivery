<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use sisVentas\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Barryvdh\DomPDF\Facade as PDF;
use DB;

class InicioController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}
	public function index()
	{
		//datos para primer chart
		$venta_i1=DB::table('venta as a')
			->select(DB::raw('sum(a.total_venta) as total_v'),DB::raw('month(a.fecha_hora) as mes_v'))
			->groupBy(DB::raw('month(a.fecha_hora)'))->get();
		$compra_i1=DB::table('ingreso as i')
			->join('persona as p','i.id_proveedor','=','p.id_persona')
			->join('ing_arti as ia','i.id_ingreso','=','ia.id_ingreso')
			->select(DB::raw('sum(ia.cantidad*ia.precio_compra) as total_c'),DB::raw('month(i.fecha_hora) as mes_c'))
			->groupBy(DB::raw('month(i.fecha_hora)'))->get();

		//datos para segundo chart
		$venta_i2=DB::table('venta as a')
			->select(DB::raw('sum(a.total_venta) as total_v'),DB::raw('month(a.fecha_hora) as mes_v'))
			->groupBy(DB::raw('month(a.fecha_hora)'))->get();

		//datos para tercer chart
		$vendidos_i3=DB::table('articulo as a')
			->select('a.nombre','a.contador')->get();

		//datos para cuarto chart
		$articulos_i4=DB::table('venta as a')
			->join('vent_art as c','a.id_venta','=','c.id_venta')
			->join('articulo as b','b.id_articulo','=','c.id_articulo')
			->select(DB::raw('sum(c.cantidad) as cant') , 'b.nombre', DB::raw('month(a.fecha_hora) as mes'))
			->groupBy('b.nombre',DB::raw('month(a.fecha_hora)'))->get();
		$artic_i4=DB::table('articulo')
			->select('nombre')->groupBy('nombre')->get();

		return view("escritorio.inicio",compact("venta_i1","compra_i1","venta_i2","vendidos_i3","articulos_i4","artic_i4"));
	}
	public function pdf(){
		$products=DB::table('articulo as a')
			->select('a.id_articulo','a.nombre','a.stock')->get();
		$pdf = PDF::loadView('pdf.products', compact('products'));
		return $pdf->download('listado.pdf');
	}
	
}
