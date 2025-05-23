<?php

return [
    'packages' => [
        'create'    => [
            'form'  => [
                'categories'    => 'الاقسام',
            ],
        ],
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'image'         => 'الصورة',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'description'           => 'الوصف',
            'image'                 => 'الصورة',
            'main_company'          => 'الاقسام الرئيسية',
            'current_users'         => 'الموظفين الحالين',
            'meta_description'      => 'Meta Description',
            'meta_keywords'         => 'Meta Keywords',
            'phone'                 => 'رقم الهاتف',
            'status'                => 'الحالة',
            'is_paid'               => 'حالة الدفع',
            'is_free'                => 'تعيين كباقة مجانية',
            'tabs'                  => [
                'category_level'    => 'مستوى الباقات',
                'company_level'     => 'مستوى القسم',
                'general'           => 'بيانات عامة',
                'seo'               => 'SEO',
                'levels'            => 'مستويات الباقة'
            ],
            'title'                 => 'عنوان',
            'users'                  => 'الموظفين',
            'website'               => 'رابط الموقع الالكتروني',
            'price'                 => 'سعر هذا المستوى',
            'job_posts'            => 'عدد طلبات التوظيف',
            'months'                => 'عدد الاشهر للشتراك ف المستوى',
            'company_in_home'       => 'الظهور ف الرئيسيه',
            'video_cv'              => 'استقبال الطلبات المصوره',
            'sort'                  => 'الترتيب',
        ],
        'routes'    => [
            'create'    => 'اضافة الباقات',
            'index'     => 'الباقات',
            'update'    => 'تعديل الباقة',
        ],
        'validation'=> [
            'category_id'   => [
                'required'  => 'من فضلك اختر مستوى الباقة',
            ],
            'image'         => [
                'required'  => 'من فضلك اختر الصورة',
            ],
            'title'         => [
                'required'  => 'من فضلك ادخل العنوان',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
