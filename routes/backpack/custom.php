<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('master', 'MasterCrudController');
    Route::crud('offer', 'OfferCrudController');
    Route::crud('feedback', 'FeedbackCrudController');
    Route::crud('moderator', 'ModeratorCrudController');
    Route::crud('user', 'UserCrudController');
    Route::crud('client', 'ClientCrudController');
    Route::crud('offer_to_master', 'Offer_to_masterCrudController');
    Route::crud('city', 'CityCrudController');
    Route::crud('spec', 'SpecCrudController');
    Route::crud('subspec', 'SubspecCrudController');
}); // this should be the absolute last line of this file