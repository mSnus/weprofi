<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\FeedbackController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('client',		ClientController::class);
Route::resource('master',		MasterController::class);
Route::resource('moderator',	ModeratorController::class);
Route::resource('request',		RequestController::class);
Route::resource('feedback',	FeedbackController::class);
