<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AreaTable extends Migration
{
	public function up()
	{
		Schema::create('area', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nombre')->nullable();
			$table->string('descripcion', 255)->nullable();
			$table->integer('sucursal')->nullable()->unsigned();
			$table->foreign('sucursal')->references('id')->on('sucursal')->onDelete('cascade');
      $table->integer('estado')->default(1);
		});
	}
	public function down()
	{
		Schema::dropIfExists('area');
	}
}
