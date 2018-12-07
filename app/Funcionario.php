<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
  protected $table = 'funcionario';
  protected $fillable = ['ci','expedido','nombre','ap_paterno','ap_materno','fec_nac','genero','departamento','ciudad','zona','calle','nro_puerta','telefono','celular','email','foto','estado','sucursal','area','cargo','usuario'];
}