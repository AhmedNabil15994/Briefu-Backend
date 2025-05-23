<?php

return [
    'jobs' => [
        'filter' => [
            'status' => 'حالة السيره الذاتيه'
        ],
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'options' => 'الخيارات',
            'status' => 'الحالة',
            'title' => 'العنوان',
            'company' => 'الشركة',
            'cvs' => 'عدد المتقدمين للوظيفة',
        ],
        'form' => [
            'status' => 'الحالة',
            'related_courses' => 'اقسام الدورات ذات الصلة بهذة الوظيفة',
            'tabs' => [
                'general' => 'بيانات عامة',
                'attributes' => 'خصائص الوظيفة'
            ],
            'title' => 'العنوان',
            'cities' => 'المحافظات',
            'description' => 'الوصف',
            'company' => 'الشركة',
            'subscription_access' => 'الإشتراك في الباقات البرو',
            'state' => 'المنطقة'
        ],
        'routes' => [
            'create' => 'اضافة الوظائف',
            'index' => 'الوظائف',
            'update' => 'تعديل الوظائف',
            'show' => 'عرض السيرة الشخصية للمتقدمين'
        ],
        'validation' => [
            'title' => [
                'required' => 'من فضلك ادخل العنوان',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
            'company_id' => [
                'required' => 'الشركة مطلوبة',
                'unique' => 'الشركة مطلوبة',
                'company_not_have_subscription' => 'الشركة ليس لديها اشتراك',
            ],
        ],
    ],

    'cvs' => [
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'options' => 'الخيارات',
            'cvs' => 'عدد المتقدمين',
            'status' => 'الحالة',
            'title' => 'الوظيفة',
            'user' => 'المتقدم للوظيفة',
            'companies' => 'الشركة',
            'jobs' => 'الوظيفة',
        ],
        'form' => [
            'status' => 'الحالة',
            'tabs' => [
                'job' => 'الوظيفة',
                'update_request' => 'تعديل الطلب',
                'cvs' => 'المتقدمين للوظيفة'
            ],
            'courses' => 'الشهادات و الكورسات',
            'from' => 'تاريخ البداية',
            'to' => 'تاريخ النهاية',
            'address' => 'الكورس / الشهادة مقدمة من ',
            'company' => 'الشركة',
            'nationality' => 'الجنسية',
            'gender' => 'الجنس',
            'qualifications' => 'المؤهل الدراسي',
            'marital_status' => 'الحالة الإجتماعية',
            'not_have_video' => 'لا يوجد فيديو',
            'not_have_pdf' => 'لا يوجد PDF',
            'company_address' => 'عنوان الشركة',
            'position' => 'الوظيفة',
            'hrs' => 'الساعات',
            'is_special' => 'احتياجات خاصة / مميزين',
            'yes' => 'نعم',
            'no' => 'لا',
            'country_of_residence' => 'بلد الإقامة',
            'graduation_info' => 'مؤهلات علمية',
            'qualification' => 'المؤهل',
            'fresh_graduate' => 'حديث التخرج',
            'graduate_year' => 'عام التخرج',
            'faculty' => 'الكلية',
            'major' => 'التخصص',
            'until_now' => 'حتى الأن',
            'address_from' => 'متخرج من',
            'video' => 'فيديو',
            'experiences' => 'الخبرات',
            'video_cv' => 'الفيديو',
            'pdf_cv' => 'PDF',
            'open' => 'عرض الفيديو',
            'open_pdf' => 'عرض PDF',
            'title' => 'العنوان',
            'target' => 'الاستهداف',
            'description' => 'الوصف',
            'email' => 'البريد الإلكتروني',
            'mobile' => 'رقم الهاتف',
            'b_day' => 'تاريخ الميلاد',
            'cv_status' => 'حالة السيفي',
            'cv_status_options' => [

                'new' => 'جديد',
                'shortlisted' => 'قائمة الإنتظار',
                'under_review' => 'قيد المراجعة',
                'approved' => 'تمت الموافقة',
                'rejected' => 'مرفوض'
            ],
            'state' => 'المنطقة'
        ],
        'routes' => [
            'create' => 'اضافة الوظائف',
            'index' => 'الوظائف',
            'update' => 'تعديل الوظائف',
            'show' => 'المتقدمين للوظيفة',
        ],
        'validation' => [
            'title' => [
                'required' => 'من فضلك ادخل العنوان',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
