<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CargoTable extends Migration
{
	public function up()
	{
		Schema::create('cargo', function (Blueprint $table) {
			$table->increments('id');
			$table->string('cargo')->nullable();
			$table->string('descripcion', 255)->nullable();
		});
	}
	public function down()
	{
		Schema::dropIfExists('cargo');
	}
}
