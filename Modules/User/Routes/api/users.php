<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user', 'middleware' => ['auth:api','user:status']], function () {

    Route::post('ask-consultation', 'UserController@addConsultation')->name('api.users.ask.consultation');

    Route::group(['prefix' => 'profile'], function () {

        Route::get('/', 'UserController@profile')->name('api.users.profile');
        Route::post('/', 'UserController@updateProfile')->name('api.users.profile');
        Route::post('/update/mobile', 'UserController@updateMobile')->name('api.users.profile.update.mobile');
        Route::put('change-password', 'UserController@changePassword')->name('api.users.change.password');

    });

    Route::put('cv', 'UserProfileController@updateCV')->name('api.users.cv.profile');
    Route::put('is-fresh-graduate', 'UserProfileController@UpdateIsFreshGraduate')->name('api.users.cv.isFreshGraduate');
    Route::post('cv-pdf', 'UserProfileController@cvPdf')->name('api.users.cv.pdf');
    Route::delete('remove-cv-pdf', 'UserProfileController@removeCvPdf')->name('api.users.remove.cv.pdf');
    Route::put('experiences', 'UserProfileController@experiences')->name('api.users.cv.experiences');
    Route::delete('delete-experiences/{id?}', 'UserProfileController@deleteExperiences')->name('api.users.cv.delete.experiences');
    Route::put('qualifications', 'UserProfileController@qualifications')->name('api.users.cv.qualifications');
    Route::put('target', 'UserProfileController@target')->name('api.users.cv.target');
    Route::put('course', 'UserProfileController@course')->name('api.users.cv.course');
    Route::delete('remove-course/{id}', 'UserProfileController@removeCourse')->name('api.users.cv.remove.course');
    Route::put('certifications', 'UserProfileController@certifications')->name('api.users.cv.certifications');
    Route::delete('delete-certifications/{id?}', 'UserProfileController@deleteCertifications')->name('api.users.cv.delete.certifications');
    Route::post('video-cv', 'UserProfileController@videoCv')->name('api.users.cv.video');
    Route::delete('delete/video-cv', 'UserProfileController@deleteVideoCv')->name('api.users.cv.video.delete');

});
