<?php

use App\Http\Controllers\SearchController;
use App\Http\Controllers\SpecController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ClientController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\TelegramController;

use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/test', '/test.php');
Route::redirect('/snusminer.php', '/snusminer.php');

Route::resource('client', ClientController::class);
Route::resource('master', MasterController::class);
Route::resource('moderator', ModeratorController::class);
Route::resource('offer', OfferController::class);
Route::resource('feedback', FeedbackController::class);

Route::view('/profile', 'profile');

/*require __DIR__.'/auth.php';
*/

Auth::routes();
Route::get('logout', function ()
{
    auth()->logout();
    Session()->flush();

    return Redirect::to('/');
})->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::put('/respond/{id}', [App\Http\Controllers\MasterController::class, 'takeOffer'])->middleware(['auth'])->name('master.respond');
Route::put('/accept/{id}/{userid}', [App\Http\Controllers\ClientController::class, 'acceptOffer'])->middleware(['auth'])->name('client.accept');
Route::get('/edit-offer/{id}', [App\Http\Controllers\ClientController::class, 'editOffer'])->middleware(['auth'])->name('client.edit-offer');

//Set Telegram webhook
//NOTE: do it only once!
//if installed, https://api.telegram.org/bot1841517749:AAGnU-etBblB5m3jmjg0ZVnw2edJX1vlIzY/getUpdates
//will return the error: Conflict: can't use getUpdates method while webhook is active; use deleteWebhook to delete the webhook first
//Telegram::setWebhook(['url' => 'https://weprofi.co.il/'.env('TELEGRAM_BOT_TOKEN').'/webhook']);

Route::post('/'.env('TELEGRAM_BOT_TOKEN').'/webhook', [TelegramController::class, 'webhook']);

Route::get('/spec/{spec_id}/{subspec_id?}', [SpecController::class, 'index'])->name('spec');
Route::get('/user/{user_id}', [UserController::class, 'index'])->name('user');
Route::get('/search/{term}', [SearchController::class, 'search'])->name('search');

