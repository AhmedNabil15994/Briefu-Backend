<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'subscriptions'], function () {

    Route::get('/', 'SubscriptionController@index');

    Route::group(['middleware' => 'auth:api'], function () {

        Route::get('free-subscription-status','SubscriptionController@freeSubscriptionStatus');
        Route::get('my-subscription','SubscriptionController@mySubscription');
        Route::put('apple-update-payment/{id}','SubscriptionController@appleUpdatePayment');
        Route::post('/subscribe/{id}', 'SubscriptionController@subscribe');
    });

    Route::get('success', 'SubscriptionController@success')
        ->name('api.subscriptions.success');

    Route::get('failed', 'SubscriptionController@failed')
        ->name('api.subscriptions.failed');
});

