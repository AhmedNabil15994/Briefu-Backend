<?php

Route::group(['prefix' => 'packages'], function () {

    Route::get('/'  , 'PackageController@packages');

});
