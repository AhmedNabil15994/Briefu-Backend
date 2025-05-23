<?php

return [
    'companies' => [
        'create'    => [
            'form'  => [
                'categories'    => 'Categories',
            ],
        ],
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'image'         => 'Image',
            'options'       => 'Options',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'form'      => [
            'description'           => 'Description',
            'image'                 => 'Image',
            'prices'                 => 'Prices',
            'instagram'             => 'Instagram',
            'current_users'         => 'Current Employees',
            'is_employees_type'     => 'Employees Type',
            'is_health_care'        => 'Health Care Type',
            'is_house_keeping_type' => 'House Keeping Type',
            'lang'                  => 'longitude',
            'lat'                   => 'lattitude',
            'main_category'         => 'Main Categories',
            'main_company'          => 'Main Company',
            'meta_description'      => 'Meta Description',
            'meta_keywords'         => 'Meta Keywords',
            'phone'                 => 'Phone Number',
            'status'                => 'Status',
            'package'               => 'Package',
            'date_from'             => 'Subcription Start From',
            'date_to'               => 'Subcription End At',
            'state'                 => 'State',
            'tabs'                  => [
                'category_level'    => 'Category Level',
                'company_level'     => 'Companies Tree',
                'general'           => 'General Info.',
                'subscriptions'     => 'Subscriptions',
                'seo'               => 'SEO',
            ],
            'title'                 => 'Title',
            'users'                  => 'Employees',
            'website'               => 'Website Link',
        ],
        'routes'    => [
            'create'    => 'Create Companies',
            'index'     => 'Companies',
            'update'    => 'Update Company',
        ],
        'validation'=> [
            'users'   => [
                'required'  => 'Please select at least one employee',
            ],
            'state_id'   => [
                'required'  => 'Please select state of company',
            ],
            'title'         => [
                'required'  => 'Please enter the title',
                'unique'    => 'This title is taken before',
            ],
        ],
    ],

    'subscriptions' => [
        'create'    => [
            'form'  => [
                'categories'    => 'Categories',
            ],
        ],
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'image'         => 'Image',
            'options'       => 'Options',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'form'      => [
            'months'                  => 'Months',
            'price'                   => 'Price',
            'job_posts'               => 'Job Posts',
            'company_in_home'         => 'Company Show in home page',
            'video_cv'                => 'Downlaod Video CV',
            'subscribe_button'        => 'Subscribe Now',
            'description'           => 'Description',
            'image'                 => 'Image',
            'instagram'             => 'Instagram',
            'current_users'         => 'Current Employees',
            'is_employees_type'     => 'Employees Type',
            'is_health_care'        => 'Health Care Type',
            'is_house_keeping_type' => 'House Keeping Type',
            'lang'                  => 'longitude',
            'lat'                   => 'lattitude',
            'main_category'         => 'Main Categories',
            'main_company'          => 'Main Company',
            'meta_description'      => 'Meta Description',
            'meta_keywords'         => 'Meta Keywords',
            'phone'                 => 'Phone Number',
            'status'                => 'Status',
            'package'               => 'Package',
            'date_from'             => 'Subcription Start From',
            'date_to'               => 'Subcription End At',
            'state'                 => 'State',
            'tabs'                  => [
                'category_level'    => 'Category Level',
                'company_level'     => 'Companies Tree',
                'general'           => 'General Info.',
                'subscriptions'     => 'Subscriptions',
                'seo'               => 'SEO',
            ],
            'title'                 => 'Title',
            'users'                  => 'Employees',
            'website'               => 'Website Link',
        ],
        'routes'    => [
            'create'    => 'Create Companies',
            'index'     => 'Subscriptions & Packages',
            'update'    => 'Update Company',
        ],
        'validation'=> [
            'users'   => [
                'required'  => 'Please select at least one employee',
            ],
            'state_id'   => [
                'required'  => 'Please select state of company',
            ],
            'title'         => [
                'required'  => 'Please enter the title',
                'unique'    => 'This title is taken before',
            ],
        ],
    ],
];
