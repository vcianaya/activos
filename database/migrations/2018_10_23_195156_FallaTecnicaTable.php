<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FallaTecnicaTable extends Migration
{
	public function up()
	{
		Schema::create('falta_tecnica', function (Blueprint $table) {
			$table->increments('id');
			$table->text('detalle')->nullable();
			$table->integer('equipo_asignado')->nullable()->unsigned();
			$table->foreign('equipo_asignado')->references('id')->on('equipo_asignado')->onDelete('cascade');
			$table->integer('equipo')->nullable()->unsigned();
			$table->foreign('equipo')->references('id')->on('equipo')->onDelete('cascade');
			$table->date('fec_falla')->nullable();
			$table->timestamps();
		});
	}
	public function down()
	{
		Schema::dropIfExists('falta_tecnica');
	}
}
