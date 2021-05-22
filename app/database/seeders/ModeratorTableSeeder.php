<?php

use Illuminate\Database\Seeder;
use App\Models\Moderator;

class ModeratorTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('moderators')->delete();

		// mod1
		Moderator::create(array(
				'username' => 'sir_mike',
				'pass' => 'pass',
				'email' => 'snus@sitebuilding.ru',
				'name' => 'Сэр Майк',
				'status' => 'active'
			));

		// mod2
		Moderator::create(array(
				'username' => 'sir_ivan',
				'pass' => 'pass',
				'email' => 'ivan@a-bot.online',
				'name' => 'Сэр Иван',
				'status' => 'active'
			));
	}
}