<?php

return [
    'attributes'    => [
        'datatable' => [
            'attributes'    => 'attributes',
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'form'      => [
            'code'      => 'Group code',
            'price'     => 'Price',
            'status'    => 'Status',
            'is_field'    => 'For targeted job',
            'image'     => 'Image',
            'tabs'      => [
                'attribute_values'  => 'attribute Values',
                'general'           => 'General Info.',
            ],
            'title'     => 'Title',
        ],
        'routes'    => [
            'create'    => 'Create attributes',
            'index'     => 'attributes',
            'update'    => 'Update attribute',
        ],
        'validation'=> [
            'title' => [
                'required'  => 'Please enter the title of attribute',
                'unique'    => 'This title attribute is taken before',
            ],
        ],
    ],
    'attributess'   => [
        'form'  => [
            'vendors'   => 'Vendor',
        ],
    ],
];
