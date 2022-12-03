<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFeedbacksTable extends Migration {

	public function up()
	{
		Schema::create('feedbacks', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('descr');
			$table->string('status', 255);
			$table->bigInteger('request')->unsigned()->nullable();
			$table->string('type', 255);
			$table->integer('score')->default(0);
			$table->bigInteger('master')->unsigned()->nullable();
			$table->bigInteger('client')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('feedbacks');
	}
}