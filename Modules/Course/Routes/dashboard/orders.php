<?php

Route::group(['prefix' => 'course_orders'], function () {

  	Route::get('/' ,'OrderController@index')
  	->name('dashboard.course_orders.index')
    ->middleware(['permission:show_course_orders']);

  	Route::get('datatable'	,'OrderController@datatable')
  	->name('dashboard.course_orders.datatable')
  	->middleware(['permission:show_course_orders']);

  	Route::get('create'		,'OrderController@create')
  	->name('dashboard.course_orders.create')
    ->middleware(['permission:add_course_orders']);

  	Route::post('/'			,'OrderController@store')
  	->name('dashboard.course_orders.store')
    ->middleware(['permission:add_course_orders']);

  	Route::get('{id}/edit'	,'OrderController@edit')
  	->name('dashboard.course_orders.edit')
    ->middleware(['permission:edit_course_orders']);

  	Route::put('{id}'		,'OrderController@update')
  	->name('dashboard.course_orders.update')
    ->middleware(['permission:edit_course_orders']);

  	Route::delete('{id}'	,'OrderController@destroy')
  	->name('dashboard.course_orders.destroy')
    ->middleware(['permission:delete_course_orders']);

  	Route::get('deletes'	,'OrderController@deletes')
  	->name('dashboard.course_orders.deletes')
    ->middleware(['permission:delete_course_orders']);

  	Route::get('{id}','OrderController@show')
  	->name('dashboard.course_orders.show')
    ->middleware(['permission:show_course_orders']);

});
