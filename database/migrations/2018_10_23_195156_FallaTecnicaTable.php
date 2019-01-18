<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FallaTecnicaTable extends Migration
{
	public function up()
	{
		Schema::create('falla_tecnica', function (Blueprint $table) {
			$table->increments('id');
			$table->text('detalle')->nullable();
			$table->integer('equipo')->nullable()->unsigned();
			$table->foreign('equipo')->references('id')->on('equipo')->onDelete('cascade');
			$table->date('fec_falla')->nullable();
      $table->text('detalle_reparacion')->nullable();
      $table->date('fec_reparacion')->nullable();
      $table->integer('estado')->nullable();
			$table->timestamps();
		});
	}
	public function down()
	{
		Schema::dropIfExists('falta_tecnica');
	}
}
