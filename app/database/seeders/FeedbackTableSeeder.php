<?php

use Illuminate\Database\Seeder;
use App\Feedback;

class FeedbackTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('feedbacks')->delete();

		// feed-client2master-1
		Feedback::create(array(
				'descr' => 'Быстро всё починил, спасибо!',
				'status' => confirmed,
				'request' => 1,
				'type' => client,
				'score' => 5,
				'master' => 1,
				'client' => 2
			));
	}
}