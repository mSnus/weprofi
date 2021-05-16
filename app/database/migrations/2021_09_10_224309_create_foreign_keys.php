<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('requests', function(Blueprint $table) {
			$table->foreign('client')->references('id')->on('clients')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('requests', function(Blueprint $table) {
			$table->foreign('master')->references('id')->on('masters')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('feedbacks', function(Blueprint $table) {
			$table->foreign('request')->references('id')->on('requests')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('feedbacks', function(Blueprint $table) {
			$table->foreign('master')->references('id')->on('masters')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('feedbacks', function(Blueprint $table) {
			$table->foreign('client')->references('id')->on('clients')
						->onDelete('set null')
						->onUpdate('set null');
		});
	}

	public function down()
	{
		Schema::table('requests', function(Blueprint $table) {
			$table->dropForeign('requests_client_foreign');
		});
		Schema::table('requests', function(Blueprint $table) {
			$table->dropForeign('requests_master_foreign');
		});
		Schema::table('feedbacks', function(Blueprint $table) {
			$table->dropForeign('feedbacks_request_foreign');
		});
		Schema::table('feedbacks', function(Blueprint $table) {
			$table->dropForeign('feedbacks_master_foreign');
		});
		Schema::table('feedbacks', function(Blueprint $table) {
			$table->dropForeign('feedbacks_client_foreign');
		});
	}
}