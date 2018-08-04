<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
	protected $table='persona';

    protected $primaryKey='id_persona';

    public $timestamps=false;

    protected $fillable =[
 		'nombre',
 		'telefono',
 		'direccion',
 		'email',
 		'tipo_perona'
    ];

    protected $guarded =[

    ];
}
