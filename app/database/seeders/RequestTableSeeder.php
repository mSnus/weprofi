<?php

use Illuminate\Database\Seeder;
use App\Request;

class RequestTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('requests')->delete();

		// request_sent
		Request::create(array(
				'title' => 'Ремонт ЭБУ на Мазду',
				'descr' => 'Нужно починить, потому что сломалось. Даю трёшку.',
				'price' => 3000,
				'client' => 1,
				'master' => null,
				'status' => 'requested'
			));

		// request_accepted
		Request::create(array(
				'title' => 'Тормоза на Газели',
				'descr' => 'Заменить чугуний на люминь за пятак',
				'price' => 5000,
				'client' => 2,
				'master' => 1,
				'status' => 'accepted',
				'accepted' => time()
			));
	}
}