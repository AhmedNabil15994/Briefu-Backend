<?php

return [
    'courses' => [
        'form' => [
            'description' => 'الوصف',
            'restore' => 'استرجاع من الحذف',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'status' => 'الحالة',
            'title' => 'عنوان الكورس',
            'type' => 'في تذيل الكورس',
            'image' => 'الصورة',
            'price' => 'السعر',
            'categories' => 'الاقسام',
            'tabs' => [
                'general' => 'بيانات عامة',
                'seo' => 'SEO',
            ],
        ],
        'routes' => [
            'create' => 'اضافة الكورسات',
            'index' => 'الكورسات',
            'update' => 'تعديل الكورس',
        ],
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'options' => 'الخيارات',
            'status' => 'الحالة',
            'title' => 'العنوان',
        ],
        'validation' => [
            'description' => [
                'required' => 'من فضلك ادخل وصف الكورس',
            ],
            'title' => [
                'required' => 'من فضلك ادخل عنوان الكورس',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],

    'course_orders' => [
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'options' => 'الخيارات',
            'cvs' => 'عدد المتقدمين',
            'status' => 'الحالة',
            'title' => 'الكورس',
            'mobile'          => 'رقم الهاتف',
            'user' => 'المتقدم للوظيفة',
            'companies' => 'الشركة'
        ],
        'form' => [
            'status' => 'الحالة',
            'tabs' => [
                'course' => 'الكورس',
                'course_orders' => 'المتقدم للكورس'
            ],
            'courses' => 'الشهادات و الكورسات',
            'from' => 'تاريخ البداية',
            'to' => 'تاريخ النهاية',
            'loading' => 'جار التحميل',
            'not_have_video_cv' => 'ليس لديه سيرة ذاتيه مصورة',
            'address' => 'الكورس / الشهادة مقدمة من ',
            'company' => 'الشركة',
            'company_address' => 'عنوان الشركة',
            'position' => 'الوظيفة',
            'hrs' => 'الساعات',
            'experiences' => 'الخبرات',
            'video_cv' => 'الفيديو',
            'open' => 'عرض الفيديو',
            'title' => 'العنوان',
            'target' => 'الاستهداف',
            'description' => 'الوصف',
            'cv_pdf'       => 'السيرة الذاتية مكتوبة',
            'state' => 'المنطقة',
            'nationality'   => 'الجنسية',
        ],
        'routes' => [
            'create' => 'اضافة طلبات الكورسات',
            'index' => 'طلبات الكورسات',
            'update' => 'تعديل طلبات الكورسات',
            'show' => 'المتقدمين للكورس',
        ],
        'validation' => [
            'title' => [
                'required' => 'من فضلك ادخل العنوان',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
