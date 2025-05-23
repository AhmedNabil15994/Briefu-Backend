<?php

Route::group(['prefix' => 'cvs'], function () {

  	Route::get('/' ,'CVSController@index')
  	->name('dashboard.cvs.index')
    ->middleware(['permission:show_cvs']);

  	Route::get('datatable'	,'CVSController@datatable')
  	->name('dashboard.cvs.datatable')
  	->middleware(['permission:show_cvs']);

  	Route::get('create'		,'CVSController@create')
  	->name('dashboard.cvs.create')
    ->middleware(['permission:add_cvs']);

  	Route::post('/'			,'CVSController@store')
  	->name('dashboard.cvs.store')
    ->middleware(['permission:add_cvs']);

  	Route::get('{id}/edit'	,'CVSController@edit')
  	->name('dashboard.cvs.edit')
    ->middleware(['permission:edit_cvs']);

  	Route::put('{id}'		,'CVSController@update')
  	->name('dashboard.cvs.update')
    ->middleware(['permission:edit_cvs']);

  	Route::delete('{id}'	,'CVSController@destroy')
  	->name('dashboard.cvs.destroy')
    ->middleware(['permission:delete_cvs']);

  	Route::get('deletes'	,'CVSController@deletes')
  	->name('dashboard.cvs.deletes')
    ->middleware(['permission:delete_cvs']);

    Route::get('cv/{jobId}/{userId}' ,'CVSController@cv')
  	->name('dashboard.cvs.cv')
    ->middleware(['permission:show_cvs']);

  	Route::get('{cvId}/{jobId}','CVSController@show')
  	->name('dashboard.cvs.show')
    ->middleware(['permission:show_cvs']);

});
