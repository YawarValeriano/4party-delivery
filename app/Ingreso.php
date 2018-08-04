<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
	protected $table='ingreso';

    protected $primaryKey='id_ingreso';

    public $timestamps=false;

    protected $fillable =[
    	'id_proveedor',
    	'num_comprobante',
    	'tipo_actividad',
    	'fecha_hora',
    	'estado'
    ];

    protected $guarded =[

    ];    
}
