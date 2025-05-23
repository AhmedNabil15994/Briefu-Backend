<?php

Route::group(['prefix' => 'courses'], function () {

  	Route::get('/' ,'CourseController@index')
  	->name('dashboard.courses.index')
    ->middleware(['permission:show_courses']);

  	Route::get('datatable'	,'CourseController@datatable')
  	->name('dashboard.courses.datatable')
  	->middleware(['permission:show_courses']);

  	Route::get('create'		,'CourseController@create')
  	->name('dashboard.courses.create')
    ->middleware(['permission:add_courses']);

  	Route::post('/'			,'CourseController@store')
  	->name('dashboard.courses.store')
    ->middleware(['permission:add_courses']);

  	Route::get('{id}/edit'	,'CourseController@edit')
  	->name('dashboard.courses.edit')
    ->middleware(['permission:edit_courses']);

  	Route::put('{id}'		,'CourseController@update')
  	->name('dashboard.courses.update')
    ->middleware(['permission:edit_courses']);

  	Route::delete('{id}'	,'CourseController@destroy')
  	->name('dashboard.courses.destroy')
    ->middleware(['permission:delete_courses']);

  	Route::get('deletes'	,'CourseController@deletes')
  	->name('dashboard.courses.deletes')
    ->middleware(['permission:delete_courses']);

  	Route::get('{id}','CourseController@show')
  	->name('dashboard.courses.show')
    ->middleware(['permission:show_courses']);

});
