<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'reset'], function () {

    // Show Forget Password Form
    Route::get('{token}', 'ResetPasswordController@resetPassword')
    ->name('frontend.password.reset');

    // Send Forget Password Via Mail
    Route::post('/', 'ResetPasswordController@updatePassword')
    ->name('frontend.password.update');

});
