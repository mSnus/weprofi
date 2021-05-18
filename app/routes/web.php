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

use App\Http\Controllers\ClientController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\FeedbackController;


Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/test', '/test.php');
Route::redirect('/snusminer.php', '/snusminer.php');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('client', ClientController::class);
// Route::view('/masters', 'masters');
Route::resource('master', MasterController::class);
Route::resource('moderator', ModeratorController::class);
Route::resource('offer', OfferController::class);
// Route::post('store-offer', [OfferController::class, 'store']);
Route::resource('feedback', FeedbackController::class);

require __DIR__.'/auth.php';
