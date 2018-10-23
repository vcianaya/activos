<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlmacenTable extends Migration
{
	public function up()
	{
		Schema::create('almacen', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nombre')->nullable();
			$table->string('descripcion')->nullable();
			$table->integer('sucursal')->nullable()->unsigned();
			$table->foreign('sucursal')->references('id')->on('sucursal')->onDelete('cascade');
		});
	}
	public function down()
	{
		Schema::dropIfExists('almacen');
	}
}
