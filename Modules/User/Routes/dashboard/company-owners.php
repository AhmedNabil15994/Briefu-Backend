<?php

Route::group(['prefix' => 'company_owners'], function () {

  	Route::get('/' ,'CompanyOwnerController@index')
  	->name('dashboard.company_owners.index')
    ->middleware(['permission:show_company_owners']);

  	Route::get('datatable'	,'CompanyOwnerController@datatable')
  	->name('dashboard.company_owners.datatable')
  	->middleware(['permission:show_company_owners']);

  	Route::get('create'		,'CompanyOwnerController@create')
  	->name('dashboard.company_owners.create')
    ->middleware(['permission:add_company_owners']);

  	Route::post('/'			,'CompanyOwnerController@store')
  	->name('dashboard.company_owners.store')
    ->middleware(['permission:add_company_owners']);

  	Route::get('{id}/edit'	,'CompanyOwnerController@edit')
  	->name('dashboard.company_owners.edit')
    ->middleware(['permission:edit_company_owners']);

  	Route::put('{id}'		,'CompanyOwnerController@update')
  	->name('dashboard.company_owners.update')
    ->middleware(['permission:edit_company_owners']);

  	Route::delete('{id}'	,'CompanyOwnerController@destroy')
  	->name('dashboard.company_owners.destroy')
    ->middleware(['permission:delete_company_owners']);

  	Route::get('deletes'	,'CompanyOwnerController@deletes')
  	->name('dashboard.company_owners.deletes')
    ->middleware(['permission:delete_company_owners']);

  	Route::get('{id}','CompanyOwnerController@show')
  	->name('dashboard.company_owners.show')
    ->middleware(['permission:show_company_owners']);

});
