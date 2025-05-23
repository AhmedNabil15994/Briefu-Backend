<?php

return [
    'attributes'    => [
        'datatable' => [
            'attributes'    => 'الخيارات',
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'code'      => 'رمز للمجموعة',
            'price'     => 'السعر',
            'status'    => 'الحالة',
            'is_field'    => 'خاصية لاستهداف الوظيفة',
            'image'     => 'الصورة',
            'tabs'      => [
                'attribute_values'  => 'القيم',
                'general'           => 'بيانات عامة',
            ],
            'title'     => 'عنوان خصائص ',
        ],
        'routes'    => [
            'create'    => 'اضافة خصائص ',
            'index'     => 'خصائص ',
            'update'    => 'تعديل خصائص ',
        ],
        'validation'=> [
            'title' => [
                'required'  => 'من فضلك ادخل عنوان خصائص ',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
    'attributess'   => [
        'form'  => [
            'vendors'   => 'المتجر',
        ],
    ],
];
