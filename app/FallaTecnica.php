<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FallaTecnica extends Model
{
	protected $table = 'falla_tecnica';
	protected $fillable = ['detalle','equipo_asignado','equipo','fec_falla','detalle_reparacion','fec_reparacion','estado',];
}
