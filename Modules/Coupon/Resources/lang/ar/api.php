<?php

return [
    'coupons' => [
        'enter' => 'ادخل الكوبون',
        'checked_successfully' => 'تم اضافة الكوبون بنجاح',
        'validation' => [

            'code' => [
                'this_coupon_not_valid_for_you' => 'هذا الكوبون  متاح فقط للعملاء المميزين',
                'coupon_not_valid_to_this_subscription' => 'هذا الكوبون غير صالحة لهذا الاشتراك',
                'required' => 'من فضلك ادخل كود الخصم',
                'already_used' => 'لقد قمت بستخدام هذا الكود من قبل',
                'exists' => 'هذا الكود غير صحيح ',
                'expired' => 'هذا الكود غير صالح ',
                'custom' => 'هذا الكود غير مخصص لك او لهذا المتجر ',
                'not_found' => 'هذا الكود غير موجود ',
            ],

            'coupon_value_greater_than_cart_total' => 'قيمة الكوبون اكبر من المبلغ الإجمالى للسلة',
            'condition_error' => 'حدث خطأ ما, الرجاء المحاولة لاحقا',
            'coupon_is_used' => 'انت بالفعل تستخدم كوبون',
            'cart_is_empty' => 'السلة فارغة, يرجى اضافة منتجات للسلة اولا',
        ],
    ],
];
