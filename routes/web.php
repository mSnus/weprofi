<?php

use App\Http\Controllers\InviteController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SpecController;
use App\Http\Controllers\StatsController;
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

use App\Http\Controllers\TelegramController;

use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/test', '/test.php');
Route::redirect('/snusminer.php', '/snusminer.php');

Route::post('/profile.update/{id}', [UserController::class, 'update']);
Route::post('/profile.avatar', [UserController::class, 'uploadAvatar']);
Route::post('/profile.gallery', [UserController::class, 'uploadGallery']);
Route::get('/profile.removeimage/{id}', [UserController::class, 'removeImage']);
Route::get('/profile.getgallery', [UserController::class, 'getGallery']);
Route::get('/profile.getavatar', [UserController::class, 'getAvatar']);

Route::get('/profile', function () {
    if (Auth::user()) {
        return view('profile');
    } else {
        return Redirect::to('/login');
    }
});

Route::get('/contact', function () {
        return view('contactus');
});

Route::post('/contact/send', [App\Http\Controllers\ContactsController::class, 'send']);

Route::get('/stats.view/{source_id}/{target_id}', [StatsController::class, 'updateViews']);


Auth::routes();

Route::get('/admin/sms', [App\Http\Controllers\SmsController::class, 'show']);
Route::post('/admin/sms', [App\Http\Controllers\SmsController::class, 'send']);

Route::get('logout', function ()
{
    auth()->logout();
    Session()->flush();

    return Redirect::to('/');
})->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Set Telegram webhook
//NOTE: do it only once!
//if installed, https://api.telegram.org/bot1841517749:AAGnU-etBblB5m3jmjg0ZVnw2edJX1vlIzY/getUpdates
//will return the error: Conflict: can't use getUpdates method while webhook is active; use deleteWebhook to delete the webhook first
//Telegram::setWebhook(['url' => 'https://weprofi.co.il/'.env('TELEGRAM_BOT_TOKEN').'/webhook']);

Route::post('/'.env('TELEGRAM_BOT_TOKEN').'/webhook', [TelegramController::class, 'webhook']);

Route::get('/spec/{spec_id}/{subspec_id?}/{region_id?}', [SpecController::class, 'index'])->name('spec');
Route::get('/user/{user_id}', [UserController::class, 'index'])->name('user');
Route::get('/search/{term}', [SearchController::class, 'search'])->name('search');

Route::get('/invite/{user_id}/{token}', [InviteController::class, 'processLink'])->name('invite');
Route::get('/reset/{phone}', [InviteController::class, 'resetPassword'])->name('reset');

Route::resource('city', App\Http\Controllers\CityController::class)->only('index', 'store');


Route::post('/feedback/{id}', [UserController::class, 'sendFeedback']);
Route::post('/quickregister', [UserController::class, 'quickRegister']);