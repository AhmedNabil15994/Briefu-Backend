<?php

Route::get('jobs', 'JobController@jobs')->name('api.jobs');
Route::get('job/{id}', 'JobController@getJobById')->name('api.job');
Route::get('jobs/{id}', 'JobController@jobById')->name('api.job');
Route::get('special-jobs', 'JobController@specialJobs')->name('api.specialJobs');
Route::get('jobs-company-id/{companyId}', 'JobController@jobsByCompanyId')->name('api.jobs.company.id');

Route::group(['prefix' => '/', 'middleware' => ['auth:api','user:status']], function () {
    Route::get('my-jobs', 'JobController@mySubmitingCv')->name('api.jobs');

    Route::get('jobs/favorites/list', 'JobController@favoritesList')->name('api.jobs.favorites.list');

    Route::post('jobs/submit-cv', 'JobController@submitCv')->name('api.jobs.submit');
    Route::post('jobs/favorites/toggle', 'JobController@favorites')->name('api.jobs.favorites');
});
