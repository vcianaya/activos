<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EquipoTable extends Migration
{
	public function up()
	{
		Schema::create('equipo', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nombre')->nullable();
			$table->string('descripcion')->nullable();
			$table->string('nro_serie')->nullable();
			$table->string('marca')->nullable();
			$table->string('modelo')->nullable();
			$table->string('modelo_procesador')->nullable();
			$table->string('codigo_siaf')->nullable();
			$table->string('codigo_qr')->nullable();
			$table->string('estado_equipo')->nullable();
			$table->string('fecha_ingreso')->nullable();
			$table->integer('categoria')->nullable()->unsigned();
			$table->foreign('categoria')->references('id')->on('categoria')->onDelete('cascade');
      $table->integer('almacen')->nullable()->unsigned();
      $table->foreign('almacen')->references('id')->on('almacen')->onDelete('cascade');
			$table->timestamps();
		});
	}
	public function down()
	{
		Schema::dropIfExists('equipo');
	}
}
