<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Model::unguard();

		$this->call('ClientTableSeeder');
		$this->command->info('Client table seeded!');

		$this->call('MasterTableSeeder');
		$this->command->info('Master table seeded!');

		$this->call('ModeratorTableSeeder');
		$this->command->info('Moderator table seeded!');

		$this->call('RequestTableSeeder');
		$this->command->info('Request table seeded!');

		$this->call('FeedbackTableSeeder');
		$this->command->info('Feedback table seeded!');
	}
}