<?php

return [
    'qualifications' => [
        'form'  => [
            'description'       => 'الوصف',
            'restore'           => 'استرجاع من الحذف',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'status'            => 'الحالة',
            'title'             => 'عنوان الصفحة',
            'type'              => 'في تذيل الصفحة',
            'tabs'  => [
              'general'   => 'بيانات عامة',
              'seo'               => 'SEO',
            ],
        ],
        'routes'    => [
          'create'  => 'اضافة المؤهلات',
          'index'   => 'المؤهلات',
          'update'  => 'تعديل المؤهل',
        ],
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'validation'=> [
            'description'   => [
                'required'  => 'من فضلك ادخل وصف المؤهل',
            ],
            'title'         => [
                'required'  => 'من فضلك ادخل عنوان المؤهل',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
