<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		$this->down();

		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('username', 255)->default('');
			$table->string('pass', 255)->default('');
			$table->string('email', 255);
			$table->string('name', 255);
			$table->string('phone', 255);
			$table->string('status', 255)->default('');
			$table->integer('score')->default(0);
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}