<?php

namespace Modules\Coupon\Http\Controllers\WebService;

use Carbon\Carbon;
use Cart;
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Cart\Traits\CartTrait;
use Modules\Catalog\Entities\Product;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Http\Requests\WebService\CouponRequest;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Subscription\Entities\Subscription;

class CouponController extends ApiController
{
    /*
     *** Start - Check Api Coupon
     */
    public function checkCoupon(CouponRequest $request)
    {
        $check = self::check($request);
       if($check[0])
        return $this->response($check['data']);
       else
        return $this->error($check[1], [], 401);
    }

    static function check($request, $subscription = null)
    {
        $coupon = Coupon::where('code', $request->coupon_code)->active()->first();
        if ($coupon) {

            if ($coupon->start_at > Carbon::now()->format('Y-m-d') || $coupon->expired_at < Carbon::now()->format('Y-m-d'))
                return [false,__('coupon::api.coupons.validation.code.expired')];

            if ($coupon->special_clients_only == 1 && $request->user()->is_special == 0) {
                    return [false,__('coupon::api.coupons.validation.code.this_coupon_not_valid_for_you')];
            }

            $subscription = $subscription ?? Subscription::active()->find($request->subscription_id);

            if(!$subscription)
                return [0 , __('subscription::api.message.not_found')];

            if ($coupon->subscriptions()->count() && !$coupon->subscriptions()->find($subscription->id)) {
                    return [false,__('coupon::api.coupons.validation.code.coupon_not_valid_to_this_subscription')];
            }

            if ($coupon->discount_type == "value")
                $discount_value = $coupon->discount_value;
            elseif ($coupon->discount_type == "percentage")
                $discount_value = (floatval($subscription->price) * $coupon->discount_percentage) / 100;
            

            $totalValue = $subscription->price - $discount_value;
            $totalValue = $totalValue >= 0 ? $totalValue : 0;

            $data = [
                'discount_value' => $discount_value > 0 ? number_format($discount_value, 2) : 0,
                'total' => number_format($totalValue, 2),
            ];

            return [true,'data' => $data,'coupon' => $coupon];
        } else {
            return [false,__('coupon::api.coupons.validation.code.not_found')];
        }
    }

    /*
     *** End - Check Api Coupon
     */
}
