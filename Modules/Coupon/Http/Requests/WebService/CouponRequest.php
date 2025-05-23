<?php

namespace Modules\Coupon\Http\Requests\WebService;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'coupon_code' => 'required|exists:coupons,code',
            'subscription_id' => 'required|exists:subscriptions,id',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [
            'coupon_code.required' => __('coupon::api.coupons.validation.code.required'),
            'coupon_code.exists' => __('coupon::api.coupons.validation.code.exists'),
        ];
        return $v;
    }
}
