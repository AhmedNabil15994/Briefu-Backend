<?php

return [
    'coupons' => [
        'enter' => 'Enter Coupon',
        'checked_successfully' => 'Coupon has been added successfully',
        'validation' => [

            'code' => [
                'this_coupon_not_valid_for_you' => 'This coupon is only available to special Clients',
                'coupon_not_valid_to_this_subscription' => 'This coupon not valid to this subscription',
                'required' => 'Please Enter Code',
                'already_used' => 'You are already used this code',
                'exists' => 'This Code Is invalid ',
                'expired' => 'This Code Is expired ',
                'custom' => 'This Code Is not available for you or this vendor ',
                'not_found' => 'Invalid Coupon Code',
            ],

            'coupon_value_greater_than_cart_total' => 'The coupon value is greater than the total value of the cart',
            'condition_error' => 'Something went wrong, please try again later',
            'coupon_is_used' => 'You are already using this coupon',
            'cart_is_empty' => 'Cart is empty, Please add products to cart firstly',
        ],
    ],
];
