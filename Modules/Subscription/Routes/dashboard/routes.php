<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group( function () {

    Route::get('bertypes/datatable'	,'BerTypeController@datatable')
        ->name('bertypes.datatable');

    Route::get('bertypes/deletes'	,'BerTypeController@deletes')
        ->name('bertypes.deletes');

    Route::resource('bertypes','BerTypeController')->names('bertypes');
});

Route::name('dashboard.')->group( function () {

    Route::get('client-subscriptions/datatable'	,'SubscriptionController@datatable')
        ->name('client-subscriptions.datatable');

    Route::get('client-subscriptions/deletes'	,'SubscriptionController@deletes')
        ->name('client-subscriptions.deletes');

    Route::resource('client-subscriptions','SubscriptionController')->names('client-subscriptions');
});