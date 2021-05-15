<?php

use Illuminate\Database\Seeder;
use App\Client;

class ClientTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('clients')->delete();

		// c1
		Client::create(array(
				'name' => 'Дарья Смешливая',
				'email' => 'darya@a-bot.online',
				'phone' => '+7 926 1231213',
				'username' => 'darya',
				'pass' => 'pass',
				'status' => 'active',
				'score' => 455
			));

		// c2
		Client::create(array(
				'name' => Марья Искусница,
				'email' => 'marya@a-bot.online',
				'phone' => '+7 926 1231214',
				'username' => 'marya',
				'pass' => 'pass',
				'status' => 'active',
				'score' => 500
			));
	}
}