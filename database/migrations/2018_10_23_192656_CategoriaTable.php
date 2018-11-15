<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoriaTable extends Migration
{
	public function up()
	{
		Schema::create('categoria', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nombre')->nullable();
      $table->date('vida_util');
			$table->text('foto')->nullable();
		});
	}
	public function down()
	{
		Schema::dropIfExists('categoria');
	}
}
