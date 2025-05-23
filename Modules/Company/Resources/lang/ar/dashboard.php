<?php

return [
    'companies' => [
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
            'prices'                 => 'اسعار الباقة',
            'main_company'          => 'الاقسام الرئيسية',
            'current_users'         => 'الموظفين الحالين',
            'meta_description'      => 'Meta Description',
            'meta_keywords'         => 'Meta Keywords',
            'phone'                 => 'رقم الهاتف',
            'status'                => 'الحالة',
            'package'               => 'الباقة',
            'date_from'             => 'يبدا الاشتراك',
            'date_to'               => 'ينتهي الاشتراك',
            'state'                 => 'المنطقة',
            'tabs'                  => [
                'category_level'    => 'مستوى الشركات',
                'company_level'     => 'مستوى القسم',
                'general'           => 'بيانات عامة',
                'subscriptions'     => 'الاشتراك',
                'seo'               => 'SEO',
            ],
            'title'                 => 'عنوان',
            'users'                  => 'الموظفين',
            'website'               => 'رابط الموقع الالكتروني',
        ],
        'routes'    => [
            'create'    => 'اضافة الشركات',
            'index'     => 'الشركات',
            'update'    => 'تعديل الشركة',
        ],
        'validation'=> [
            'users'   => [
                'required'  => 'من فضلك اختر احد القائمين على الشركة',
            ],
            'state_id'   => [
                'required'  => 'من فضلك اختر العنوان للشركة',
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
    'subscriptions' => [
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
            'months'                  => 'الاشهر',
            'price'                   => 'السعر',
            'job_posts'               => 'عدد الوظائف',
            'company_in_home'         => 'عرض الشركة في الرئيسية',
            'video_cv'                => 'مشاهدة السيرة الذاتية المصورة',
            'subscribe_button'        => 'اشترك الان',

            'description'           => 'الوصف',
            'image'                 => 'الصورة',
            'main_company'          => 'الاقسام الرئيسية',
            'current_users'         => 'الموظفين الحالين',
            'meta_description'      => 'Meta Description',
            'meta_keywords'         => 'Meta Keywords',
            'phone'                 => 'رقم الهاتف',
            'status'                => 'الحالة',
            'package'               => 'الباقة',
            'date_from'             => 'يبدا الاشتراك',
            'date_to'               => 'ينتهي الاشتراك',
            'state'                 => 'المنطقة',
            'tabs'                  => [
                'category_level'    => 'مستوى الشركات',
                'company_level'     => 'مستوى القسم',
                'general'           => 'بيانات عامة',
                'subscriptions'     => 'الاشتراك',
                'seo'               => 'SEO',
            ],
            'title'                 => 'عنوان',
            'users'                  => 'الموظفين',
            'website'               => 'رابط الموقع الالكتروني',
        ],
        'routes'    => [
            'create'    => 'اضافة الشركات',
            'index'     => 'الاشتراكات و الباقات',
            'update'    => 'تعديل الشركة',
        ],
        'validation'=> [
            'users'   => [
                'required'  => 'من فضلك اختر احد القائمين على الشركة',
            ],
            'state_id'   => [
                'required'  => 'من فضلك اختر العنوان للشركة',
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
