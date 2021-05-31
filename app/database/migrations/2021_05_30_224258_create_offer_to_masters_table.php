<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOfferToMastersTable extends Migration {

	public function up()
	{
		Schema::create('offer_to_masters', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->bigInteger('offer');
			$table->bigInteger('master');
		});
	}

	public function down()
	{
		Schema::drop('offer_to_masters');
	}
}