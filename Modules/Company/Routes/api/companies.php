<?php

Route::group(['prefix' => 'companies'], function () {

    Route::get('/'  , 'CompanyController@companies');

});
