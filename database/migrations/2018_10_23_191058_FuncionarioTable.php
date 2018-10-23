<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FuncionarioTable extends Migration
{
	public function up()
	{
		Schema::create('funcionario', function (Blueprint $table) {
			$table->increments('id');
			$table->string('ci')->nullable();
			$table->string('expedido')->nullable();
			$table->string('nombre')->nullable();
			$table->string('ap_paterno')->nullable();
			$table->string('ap_materno')->nullable();
			$table->date('fec_nac')->nullable();
			$table->string('genero')->nullable();
			$table->string('departamento')->nullable();
			$table->string('ciudad')->nullable();
			$table->string('zona')->nullable();
			$table->string('calle')->nullable();
			$table->integer('nro_puerta')->nullable();
			$table->integer('telefono')->nullable();
			$table->integer('celular')->nullable();
			$table->string('email')->nullable();
			$table->text('foto')->nullable();
			$table->integer('estado')->nullable();
			$table->integer('sucursal')->nullable()->unsigned();
			$table->foreign('sucursal')->references('id')->on('sucursal')->onDelete('cascade');
			$table->integer('area')->nullable()->unsigned();
			$table->foreign('area')->references('id')->on('area')->onDelete('cascade');
			$table->integer('cargo')->nullable()->unsigned();
			$table->foreign('cargo')->references('id')->on('cargo')->onDelete('cascade');
			$table->integer('usuario')->nullable()->unsigned();
			$table->foreign('usuario')->references('id')->on('users')->onDelete('cascade');
			$table->timestamps();
		});
	}
	public function down()
	{
		Schema::dropIfExists('funcionario');
	}
}
