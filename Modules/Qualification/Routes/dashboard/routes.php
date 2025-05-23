<?php

Route::group(['prefix' => 'qualifications'], function () {

  	Route::get('/' ,'QualificationController@index')
  	->name('dashboard.qualifications.index')
    ->middleware(['permission:show_qualifications']);

  	Route::get('datatable'	,'QualificationController@datatable')
  	->name('dashboard.qualifications.datatable')
  	->middleware(['permission:show_qualifications']);

  	Route::get('create'		,'QualificationController@create')
  	->name('dashboard.qualifications.create')
    ->middleware(['permission:add_qualifications']);

  	Route::post('/'			,'QualificationController@store')
  	->name('dashboard.qualifications.store')
    ->middleware(['permission:add_qualifications']);

  	Route::get('{id}/edit'	,'QualificationController@edit')
  	->name('dashboard.qualifications.edit')
    ->middleware(['permission:edit_qualifications']);

  	Route::put('{id}'		,'QualificationController@update')
  	->name('dashboard.qualifications.update')
    ->middleware(['permission:edit_qualifications']);

  	Route::delete('{id}'	,'QualificationController@destroy')
  	->name('dashboard.qualifications.destroy')
    ->middleware(['permission:delete_qualifications']);

  	Route::get('deletes'	,'QualificationController@deletes')
  	->name('dashboard.qualifications.deletes')
    ->middleware(['permission:delete_qualifications']);

  	Route::get('{id}','QualificationController@show')
  	->name('dashboard.qualifications.show')
    ->middleware(['permission:show_qualifications']);

});
