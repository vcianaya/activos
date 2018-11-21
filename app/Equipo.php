<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
	protected $table = 'equipo';
	protected $fillable = ['observacion','descripcion','nro_serie','marca','modelo','modelo_procesador','codigo_siaf','codigo_qr','estado_equipo','fecha_ingreso','categoria','almacen'];
}