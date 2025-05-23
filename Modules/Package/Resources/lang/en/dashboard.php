<?php

return [
    'packages' => [
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
            'instagram'             => 'Instagram',
            'current_users'         => 'Current Employees',
            'is_employees_type'     => 'Employees Type',
            'is_health_care'        => 'Health Care Type',
            'is_house_keeping_type' => 'House Keeping Type',
            'lang'                  => 'longitude',
            'lat'                   => 'lattitude',
            'main_category'         => 'Main Categories',
            'main_company'          => 'Main Package',
            'meta_description'      => 'Meta Description',
            'meta_keywords'         => 'Meta Keywords',
            'phone'                 => 'Phone Number',
            'is_paid'               => 'Paid Status',
            'status'                => 'Status',
            'is_free'                => 'set as a free Package',
            'tabs'                  => [
                'category_level'    => 'Category Level',
                'company_level'     => 'Packages Tree',
                'general'           => 'General Info.',
                'seo'               => 'SEO',
                'levels'            => 'Package Levels'
            ],
            'title'                 => 'Title',
            'users'                  => 'Employees',
            'website'               => 'Website Link',
            'price'                 => 'Price in this level',
            'job_posts'             => 'Number of job posts',
            'months'                => 'Months of level',
            'company_in_home'       => 'Company Visible in home app',
            'video_cv'              => 'Accept Video CV',
            'sort'                  => 'Sort',
        ],
        'routes'    => [
            'create'    => 'Create Packages',
            'index'     => 'Packages',
            'update'    => 'Update Package',
        ],
        'validation'=> [
            'category_id'   => [
                'required'  => 'Please select company level',
            ],
            'image'         => [
                'required'  => 'Please select image',
            ],
            'title'         => [
                'required'  => 'Please enter the title',
                'unique'    => 'This title is taken before',
            ],
        ],
    ],
];
