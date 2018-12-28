<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipoAsignado extends Model
{
	protected $table = 'equipo_asignado';
	protected $fillable = ['equipo','funcionario','usuario','detalle_asignacion','fec_asignacion','fec_devolucion','detalle_devolucion','estado'];

  public function scopeVerificarAsignacion($query,$id_equipo)
  {
    //1 ASIGNADO
    //0 DEVUELTO
    $equipoAsignado = EquipoAsignado::join('funcionario','equipo_asignado.funcionario','=','funcionario.id')
                      ->select('funcionario.nombre','funcionario.ap_paterno','funcionario.ap_materno')
                      ->where('equipo_asignado.estado',1)->where('equipo_asignado.equipo',$id_equipo)->first();
    if (count($equipoAsignado) > 0) {
      return '<span class="label label-warning">'.$equipoAsignado->nombre.' '.$equipoAsignado->ap_paterno.' '.$equipoAsignado->ap_materno.'</span>';
    }else{
      return '<span class="label label-success">EQUIPO DISPONIBLE</span>';
    }
  }
}