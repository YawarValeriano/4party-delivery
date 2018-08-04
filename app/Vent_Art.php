<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Vent_Art extends Model
{
    protected $table='vent_art';

    protected $primaryKey='id_vent_art';

    public $timestamps=false;

    protected $fillable =[
    	'id_venta',
    	'id_articulo',
    	'cantidad',
    	'precio_venta'
    ];

    protected $guarded =[

    ];
}
