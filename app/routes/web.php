<?php

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

use App\Http\Controllers\OfferController;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/snusminer.php', '/snusminer.php');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('client', 'ClientController');
Route::resource('master', 'MasterController');
Route::resource('moderator', 'ModeratorController');
// Route::resource('offer', 'OfferController');
Route::post('store-offer', [OfferController::class, 'store']);
Route::resource('feedback', 'FeedbackController');

require __DIR__.'/auth.php';
