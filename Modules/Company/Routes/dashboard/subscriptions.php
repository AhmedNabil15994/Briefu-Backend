<?php

Route::group(['prefix' => 'subscriptions'], function () {

  	Route::get('/' ,'SubscriptionController@index')
  	->name('dashboard.subscriptions.index')
    ->middleware(['permission:show_subscriptions']);

  	Route::get('datatable'	,'SubscriptionController@datatable')
  	->name('dashboard.subscriptions.datatable')
  	->middleware(['permission:show_subscriptions']);

  	Route::get('{id}/levels/show/' ,'SubscriptionController@getLevels')
  	->name('dashboard.subscriptions.getlevels')
    ->middleware(['permission:show_subscriptions']);

  	Route::get('create'		,'SubscriptionController@create')
  	->name('dashboard.subscriptions.create')
    ->middleware(['permission:add_subscriptions']);

  	Route::post('/'			,'SubscriptionController@store')
  	->name('dashboard.subscriptions.store')
    ->middleware(['permission:add_subscriptions']);

  	Route::get('{id}/edit'	,'SubscriptionController@edit')
  	->name('dashboard.subscriptions.edit')
    ->middleware(['permission:edit_subscriptions']);

  	Route::put('{id}'		,'SubscriptionController@update')
  	->name('dashboard.subscriptions.update')
    ->middleware(['permission:edit_subscriptions']);

  	Route::delete('{id}'	,'SubscriptionController@destroy')
  	->name('dashboard.subscriptions.destroy')
    ->middleware(['permission:delete_subscriptions']);

  	Route::get('deletes'	,'SubscriptionController@deletes')
  	->name('dashboard.subscriptions.deletes')
    ->middleware(['permission:delete_subscriptions']);

  	Route::get('{id}','SubscriptionController@show')
  	->name('dashboard.subscriptions.show')
    ->middleware(['permission:show_subscriptions']);

});
