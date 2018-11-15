<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EquipoAsignadoTable extends Migration
{
	public function up()
	{
		Schema::create('equipo_asignado', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('equipo')->nullable()->unsigned();
			$table->foreign('equipo')->references('id')->on('equipo')->onDelete('cascade');
			$table->integer('funcionario')->nullable()->unsigned();
			$table->foreign('funcionario')->references('id')->on('funcionario')->onDelete('cascade');
			$table->integer('usuario')->nullable()->unsigned();
			$table->foreign('usuario')->references('id')->on('users')->onDelete('cascade');
			$table->text('detalle_asignacion')->nullable();
			$table->date('fec_asignacion')->nullable();
			$table->date('fec_devolucion')->nullable();
			$table->text('detalle_devolucion')->nullable();
			$table->integer('estado')->nullable();
			$table->timestamps();
		});
	}
	public function down()
	{
		Schema::dropIfExists('equipo_asignado');
	}
}
