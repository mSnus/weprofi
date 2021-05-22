<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title', 255);
			$table->text('descr');
			$table->bigInteger('price')->default(0);
			$table->bigInteger('client')->unsigned()->nullable()->index();
			$table->bigInteger('master')->unsigned()->nullable()->default('NULL');
			$table->string('status', 255)->default('');
			$table->string('location', 255)->default('');
			$table->timestamp('accepted')->useCurrent();
			$table->timestamp('finished')->useCurrent();
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}