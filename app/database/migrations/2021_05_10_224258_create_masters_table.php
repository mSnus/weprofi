<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMastersTable extends Migration {

	public function up()
	{
		Schema::create('masters', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->bigInteger('userid');
			$table->string('title', 255);
			$table->text('descr', 255);
			$table->string('status', 255);
			$table->string('location', 255);
			$table->integer('score')->default(0);
		});
	}

	public function down()
	{
		Schema::drop('masters');
	}
}