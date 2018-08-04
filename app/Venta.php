<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table='venta';

    protected $primaryKey='id_venta';

    public $timestamps=false;

    protected $fillable =[
    	'id_cliente',
    	'id_usuario',
    	'num_comprobante',
    	'tipo_actividad',
    	'fecha_hora',
    	'total_venta',
    	'estado'
    ];

    protected $guarded =[

    ];
}
