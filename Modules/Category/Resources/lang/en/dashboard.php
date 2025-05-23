<?php

return [
    'categories'    => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'image'         => 'Image',
            'options'       => 'Options',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'form'      => [
            'color'             => 'Theme Color',
            'image'             => 'Image',
            'restore'             => 'Restore',
            'main_category'     => 'Main Category',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'status'            => 'Status',
            'tabs'              => [
                'category_level'    => 'Categories Tree',
                'general'           => 'General Info.',
                'seo'               => 'SEO',
            ],
            'title'             => 'Title',
        ],
        'routes'    => [
            'create'    => 'Create Categories',
            'index'     => 'Categories',
            'sorting'   => 'Sorting',
            'update'    => 'Update Category',
        ],
        'validation'=> [
            'category_id'   => [
                'required'  => 'Please select category level',
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
