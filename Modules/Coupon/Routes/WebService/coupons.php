<?php

Route::group(['prefix' => 'coupons','middleware' => ['auth:api']], function () {

  	Route::post('/check_coupon' ,'CouponController@checkCoupon')
  	->name('api.check_coupon');


});
