<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMastersTable extends Migration {

	public function up()
	{
		Schema::create('masters', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('username', 255);
			$table->string('pass', 255);
			$table->string('email', 255);
			$table->string('name', 255);
			$table->string('phone', 255);
			$table->string('status', 255);
			$table->integer('score');
		});
	}

	public function down()
	{
		Schema::drop('masters');
	}
}