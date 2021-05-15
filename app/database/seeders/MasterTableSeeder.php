<?php

use Illuminate\Database\Seeder;
use App\Master;

class MasterTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('masters')->delete();

		// m1
		Master::create(array(
				'name' => 'Михайло Иванович',
				'phone' => '+7 925 1234567',
				'username' => 'master_mik',
				'pass' => 'pass',
				'status' => 'enabled',
				'score' => 55
			));

		// m2
		Master::create(array(
				'name' => 'Пётр Семёныч',
				'phone' => '+7 926 999-9999',
				'username' => 'master_petya',
				'pass' => 'pass',
				'status' => 'disabled',
				'score' => 33
			));
	}
}