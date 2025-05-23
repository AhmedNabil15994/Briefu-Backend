<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'nationalities'], function () {

    Route::get('/'   , 'NationalityController@index')->name('api.nationalities.index');

});
