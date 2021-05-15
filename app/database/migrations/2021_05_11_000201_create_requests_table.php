<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRequestsTable extends Migration {

	public function up()
	{
		Schema::create('requests', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title', 255);
			$table->text('descr');
			$table->bigInteger('price');
			$table->bigInteger('client')->unsigned()->nullable()->index();
			$table->bigInteger('master')->unsigned()->nullable();
			$table->string('status', 255);
			$table->timestamp('accepted')->useCurrent();
			$table->timestamp('finished')->useCurrent();
		});
	}

	public function down()
	{
		Schema::drop('requests');
	}
}