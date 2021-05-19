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
Route::resource('master', MasterController::class);
Route::resource('moderator', ModeratorController::class);
Route::resource('offer', OfferController::class);
Route::resource('feedback', FeedbackController::class);

require __DIR__.'/auth.php';


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('masters')->name('masters/')->group(static function() {
            Route::get('/',                                             'MastersController@index')->name('index');
            Route::get('/create',                                       'MastersController@create')->name('create');
            Route::post('/',                                            'MastersController@store')->name('store');
            Route::get('/{master}/edit',                                'MastersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'MastersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{master}',                                    'MastersController@update')->name('update');
            Route::delete('/{master}',                                  'MastersController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('offers')->name('offers/')->group(static function() {
            Route::get('/',                                             'OffersController@index')->name('index');
            Route::get('/create',                                       'OffersController@create')->name('create');
            Route::post('/',                                            'OffersController@store')->name('store');
            Route::get('/{offer}/edit',                                 'OffersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'OffersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{offer}',                                     'OffersController@update')->name('update');
            Route::delete('/{offer}',                                   'OffersController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('clients')->name('clients/')->group(static function() {
            Route::get('/',                                             'ClientsController@index')->name('index');
            Route::get('/create',                                       'ClientsController@create')->name('create');
            Route::post('/',                                            'ClientsController@store')->name('store');
            Route::get('/{client}/edit',                                'ClientsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ClientsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{client}',                                    'ClientsController@update')->name('update');
            Route::delete('/{client}',                                  'ClientsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('users')->name('users/')->group(static function() {
            Route::get('/',                                             'UsersController@index')->name('index');
            Route::get('/create',                                       'UsersController@create')->name('create');
            Route::post('/',                                            'UsersController@store')->name('store');
            Route::get('/{user}/edit',                                  'UsersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'UsersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{user}',                                      'UsersController@update')->name('update');
            Route::delete('/{user}',                                    'UsersController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('moderators')->name('moderators/')->group(static function() {
            Route::get('/',                                             'ModeratorsController@index')->name('index');
            Route::get('/create',                                       'ModeratorsController@create')->name('create');
            Route::post('/',                                            'ModeratorsController@store')->name('store');
            Route::get('/{moderator}/edit',                             'ModeratorsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ModeratorsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{moderator}',                                 'ModeratorsController@update')->name('update');
            Route::delete('/{moderator}',                               'ModeratorsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('feedback')->name('feedback/')->group(static function() {
            Route::get('/',                                             'FeedbacksController@index')->name('index');
            Route::get('/create',                                       'FeedbacksController@create')->name('create');
            Route::post('/',                                            'FeedbacksController@store')->name('store');
            Route::get('/{feedback}/edit',                              'FeedbacksController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'FeedbacksController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{feedback}',                                  'FeedbacksController@update')->name('update');
            Route::delete('/{feedback}',                                'FeedbacksController@destroy')->name('destroy');
        });
    });
});