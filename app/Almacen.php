<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
  protected $table = 'almacen';
  protected $fillable = ['nombre','descripcion','sucursal','estado'];
  public $timestamps = false;
}
