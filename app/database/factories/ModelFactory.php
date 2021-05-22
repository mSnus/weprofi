<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'last_login_at' => $faker->dateTime,
        
    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Master::class, static function (Faker\Generator $faker) {
    return [
        'userid' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'title' => $faker->sentence,
        'descr' => $faker->text(),
        'status' => $faker->sentence,
        'score' => $faker->randomNumber(5),
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Offer::class, static function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'title' => $faker->sentence,
        'descr' => $faker->text(),
        'price' => $faker->sentence,
        'client' => $faker->randomNumber(5),
        'master' => $faker->randomNumber(5),
        'status' => $faker->sentence,
        'location' => $faker->sentence,
        'accepted' => $faker->dateTime,
        'finished' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Client::class, static function (Faker\Generator $faker) {
    return [
        'userid' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'title' => $faker->sentence,
        'status' => $faker->sentence,
        'score' => $faker->randomNumber(5),
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, static function (Faker\Generator $faker) {
    return [
        'usertype' => $faker->randomNumber(5),
        'name' => $faker->firstName,
        'email' => $faker->email,
        'email_verified_at' => $faker->dateTime,
        'password' => bcrypt($faker->password),
        'two_factor_secret' => $faker->text(),
        'two_factor_recovery_codes' => $faker->text(),
        'remember_token' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Moderator::class, static function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'username' => $faker->sentence,
        'pass' => $faker->sentence,
        'email' => $faker->email,
        'name' => $faker->firstName,
        'status' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Feedback::class, static function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'descr' => $faker->text(),
        'status' => $faker->sentence,
        'request' => $faker->randomNumber(5),
        'type' => $faker->sentence,
        'score' => $faker->boolean(),
        'master' => $faker->randomNumber(5),
        'client' => $faker->randomNumber(5),
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Feedback::class, static function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'descr' => $faker->text(),
        'status' => $faker->sentence,
        'request' => $faker->randomNumber(5),
        'type' => $faker->sentence,
        'score' => $faker->randomNumber(5),
        'master' => $faker->randomNumber(5),
        'client' => $faker->randomNumber(5),
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Master::class, static function (Faker\Generator $faker) {
    return [
        'userid' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'title' => $faker->sentence,
        'descr' => $faker->text(),
        'location' => $faker->sentence,
        'status' => $faker->sentence,
        'score' => $faker->randomNumber(5),
        
        
    ];
});
