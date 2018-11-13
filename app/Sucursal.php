<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
	protected $table = 'sucursal';
	protected $fillable = ['nit','nombre','departamento','ciudad','zona','calle','num_puerta','telefono','celular','email','fax','foto','estado','user'];
}

