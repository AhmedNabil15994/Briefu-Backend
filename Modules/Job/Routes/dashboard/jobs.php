<?php

Route::group(['prefix' => 'jobs'], function () {

  	Route::get('/' ,'JobController@index')
  	->name('dashboard.jobs.index')
    ->middleware(['permission:show_jobs']);

  	Route::get('datatable'	,'JobController@datatable')
  	->name('dashboard.jobs.datatable')
  	->middleware(['permission:show_jobs']);

  	Route::get('create'		,'JobController@create')
  	->name('dashboard.jobs.create')
    ->middleware(['permission:add_jobs']);

  	Route::post('/'			,'JobController@store')
  	->name('dashboard.jobs.store')
    ->middleware(['permission:add_jobs']);

  	Route::get('{id}/edit'	,'JobController@edit')
  	->name('dashboard.jobs.edit')
    ->middleware(['permission:edit_jobs']);

  	Route::put('{id}'		,'JobController@update')
  	->name('dashboard.jobs.update')
    ->middleware(['permission:edit_jobs']);

  	Route::delete('{id}'	,'JobController@destroy')
  	->name('dashboard.jobs.destroy')
    ->middleware(['permission:delete_jobs']);

  	Route::get('deletes'	,'JobController@deletes')
  	->name('dashboard.jobs.deletes')
    ->middleware(['permission:delete_jobs']);

  	Route::get('{id}','JobController@show')
  	->name('dashboard.jobs.show')
    ->middleware(['permission:show_jobs']);

});
