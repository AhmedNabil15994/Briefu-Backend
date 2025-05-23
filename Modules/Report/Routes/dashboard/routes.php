<?php

Route::group(['prefix' => 'reports'], function () {

  	Route::get('subscriptions' ,'ReportSubscriptionController@index')
  	->name('dashboard.reports.subscriptions.index')
    ->middleware(['permission:show_reports']);

	Route::get('subscriptions/exports/{pdf}' , 'ReportSubscriptionController@export')
	->name('dashboard.reports.subscriptions.export')
	->middleware(['permission:show_reports']);

  	Route::get('datatable'	,'ReportSubscriptionController@datatable')
  	->name('dashboard.reports.subscriptions.datatable')
  	->middleware(['permission:show_reports']);

	//client subscription
	Route::get('client-subscription' ,'ReportClientSubscriptionController@index')
	->name('dashboard.reports.client.subscriptions.index')
  	->middleware(['permission:show_reports']);
	
	Route::get('client-subscription/exports/{pdf}' , 'ReportClientSubscriptionController@export')
	->name('dashboard.reports.client.subscriptions.export')
	->middleware(['permission:show_reports']);


	Route::get('client-subscription/datatable'	,'ReportClientSubscriptionController@datatable')
	->name('dashboard.reports.client.subscriptions.datatable')
	->middleware(['permission:show_reports']);

	//consultations
	Route::get('consultations' ,'ReportConsultationController@index')
	->name('dashboard.reports.consultations.index')
  	->middleware(['permission:show_consultations_reports']);
	
	Route::get('consultations/exports/{pdf}' , 'ReportConsultationController@export')
	->name('dashboard.reports.consultations.export')
	->middleware(['permission:show_consultations_reports']);


	Route::get('consultations/datatable'	,'ReportConsultationController@datatable')
	->name('dashboard.reports.consultations.datatable')
	->middleware(['permission:show_consultations_reports']);

    Route::get('consultations/switch/{id}/{action}', 'ReportConsultationController@switcher')->name('dashboard.reports.consultations.switch');

	//users
	Route::get('users' ,'ReportUserController@index')
	->name('dashboard.reports.users.index')
  	->middleware(['permission:show_reports']);
	
	Route::get('users/exports/{pdf}' , 'ReportUserController@export')
	->name('dashboard.reports.users.export')
	->middleware(['permission:show_reports']);


	Route::get('users/datatable','ReportUserController@datatable')
	->name('dashboard.reports.users.datatable')
	->middleware(['permission:show_reports']);
});
