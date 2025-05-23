<?php

Route::group(['prefix' => 'qualifications'], function () {

    Route::get('/'      , 'QualificationController@qualifications')->name('api.qualifications.index');
    Route::get('{id}'   , 'QualificationController@page')->name('api.qualifications.show');

});
