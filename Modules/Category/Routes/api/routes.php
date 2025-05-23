<?php

Route::group(['prefix' => 'categories'], function () {

    Route::get('/'      , 'CategoryController@categories')->name('api.categories.index');
    Route::get('{id}'   , 'CategoryController@category')->name('api.categories.show');

});
