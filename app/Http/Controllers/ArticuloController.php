<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\ArticuloFormRequest;
use sisVentas\Articulo;
use DB;

class ArticuloController extends Controller
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
			$articulos=DB::table('articulo as a')
				->join('categoria as c','a.id_categoria','=','c.id_categoria')
				->select('a.id_articulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado')
				->where('a.nombre','LIKE','%'.$query.'%')
                ->orwhere('a.codigo','LIKE','%'.$query.'%')
				->orderBy('a.id_articulo','asc')
				->paginate(7);
			return view("almacen.articulo.index",["articulos"=>$articulos,"searchText"=>$query]);
		}
	}
	public function create()
    {
    	$categorias=DB::table('categoria')->where('condicion','=','1')->get();

        return view("almacen.articulo.create",["categorias"=>$categorias]);
    }
    public function store(ArticuloFormRequest $request)
    {
        $articulo=new Articulo;
        $articulo->id_categoria=$request->get('id_categoria');
        $articulo->codigo=$request->get('codigo');
        $articulo->nombre=$request->get('nombre');
        $articulo->stock=$request->get('stock');
        $articulo->descripcion=$request->get('descripcion');
        $articulo->estado='Activo';
        if (Input::hasFile('imagen')) {
        	$file=Input::file('imagen');
        	$file->move(public_path().'/imagenes/articulos',$file->getClientOriginalName());
        	$articulo->imagen=$file->getClientOriginalName();
        }
        $articulo->contador=0;
        $articulo->save();
        return Redirect::to('almacen/articulo');
    }
    public function show()
    {
        $articulos=DB::table('articulo as a')
            ->join('categoria as c','a.id_categoria','=','c.id_categoria')
            ->select('a.id_articulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado')
            ->orderBy('a.id_articulo','asc');
        $pdf = \PDF::loadView('almacen.articulo.pdf_articulos', compact('articulos'));
        return $pdf->stream('Articulos.pdf');
    }
    public function downloadPDF()
    {
        $articulos=DB::table('articulo as a')
                ->join('categoria as c','a.id_categoria','=','c.id_categoria')
                ->select('a.id_articulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.estado')
                ->orderBy('a.id_articulo','asc')->paginate(10);
        $ver=view('almacen.articulo.pdf_articulos', compact('articulos'));        
        $pdf=\App::make('dompdf.wrapper');
        $pdf->loadHTML($ver);
        return $ver;
    }
    public function edit($id)
    {
    	$articulo=Articulo::findOrFail($id);
    	$categorias=DB::table('categoria')->where('condicion','=','1')->get();
        return view("almacen.articulo.edit",["articulo"=>$articulo,"categorias"=>$categorias]);
    }
    public function update(ArticuloFormRequest $request,$id)
    {
        $articulo=Articulo::findOrFail($id);
        $articulo->id_categoria=$request->get('id_categoria');
        $articulo->codigo=$request->get('codigo');
        $articulo->nombre=$request->get('nombre');
        $articulo->stock=$request->get('stock');
        $articulo->descripcion=$request->get('descripcion');        
        if (Input::hasFile('imagen')) {
        	$file=Input::file('imagen');
        	$file->move(public_path().'/imagenes/articulos',$file->getClientOriginalName());
        	$articulo->imagen=$file->getClientOriginalName();
        }
        $articulo->update();
        return Redirect::to('almacen/articulo');
    }
    public function destroy($id)
    {
        $articulo=Articulo::findOrFail($id);
        $articulo->estado='Inactivo';
        $articulo->update();
        return Redirect::to('almacen/articulo');
    }
}
