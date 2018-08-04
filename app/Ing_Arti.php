<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Ing_Arti extends Model
{
    protected $table='ing_arti';

    protected $primaryKey='id_ing_arti';

    public $timestamps=false;

    protected $fillable =[
    	'id_articulo',
    	'id_ingreso',
    	'cantidad',
    	'precio_compra',
    	'precio_venta'
    ];

    protected $guarded =[

    ];
}
