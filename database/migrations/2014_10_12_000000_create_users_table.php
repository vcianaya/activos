<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('ci')->nullable();
			$table->string('expedido')->nullable();
			$table->string('nombre')->nullable();
			$table->string('ap_paterno')->nullable();
			$table->string('ap_materno')->nullable();
			$table->string('email')->unique();
			$table->string('password');
			$table->text('foto')->nullable();
      $table->integer('estado')->nullable();
			$table->rememberToken();
			$table->timestamps();
		});
	}
	public function down()
	{
		Schema::dropIfExists('users');
	}
}
