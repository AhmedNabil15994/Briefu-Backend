<?php

Route::group(['prefix' => 'courses'], function () {

    Route::get('/'      , 'CourseController@courses')->name('api.courses.index');
    Route::get('{id}'   , 'CourseController@course')->name('api.courses.show');

});
