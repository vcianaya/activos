<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SucursalTable extends Migration
{
	public function up()
	{
		Schema::create('sucursal', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nit')->nullable();
			$table->string('nombre')->nullable();
			$table->string('departamento')->nullable();
			$table->string('ciudad')->nullable();
			$table->string('zona')->nullable();
			$table->string('calle')->nullable();
			$table->integer('num_puerta')->nullable();
			$table->integer('telefono')->nullable();
			$table->integer('celular')->nullable();
			$table->string('email')->nullable();
			$table->integer('fax')->nullable();
			$table->text('foto')->nullable();
			$table->string('estado')->nullable();
			$table->integer('user')->nullable()->unsigned();
			$table->foreign('user')->references('id')->on('users')->onDelete('cascade');
			$table->timestamps();
		});
	}
	public function down()
	{
		Schema::dropIfExists('sucursal');
	}
}
