<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {

    Route::post('login'             , 'LoginController@postLogin')->name('api.auth.login');
    Route::post('register'          , 'RegisterController@register')->name('api.auth.register');
    Route::post('resend-otp'          , 'VerificationOtpController@resendOtp')->name('api.auth.resend.otp');
    Route::post('company/register'  , 'RegisterController@companyRegister')->name('api.auth.company.register');
    Route::post('forget-password'   , 'ForgotPasswordController@forgetPassword')->name('api.auth.password.forget');

    Route::group(['prefix' => '/','middleware' => ['auth:api','user:status']], function () {

        Route::post('logout', 'LoginController@logout')->name('api.auth.logout');
        Route::delete('delete-account', 'LoginController@deleteAccount')->name('api.auth.delete.account');

    });
});

Route::group(['prefix' => '/user','middleware' => ['auth:api','user:status']], function () {

    Route::delete('delete-account', 'LoginController@deleteAccount')->name('api.auth.delete.account');
});