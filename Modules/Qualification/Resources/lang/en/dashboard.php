<?php

return [
    'qualifications' => [
      'form'  => [
          'description'       => 'Description',
          'restore'           => 'Restore from trash',
          'meta_description'  => 'Meta Description',
          'meta_keywords'     => 'Meta Keywords',
          'status'            => 'Status',
          'title'             => 'Title',
          'type'              => 'In footer',
          'tabs'  => [
            'general'           => 'General Info.',
            'seo'               => 'SEO',
          ]
      ],
      'datatable' => [
          'created_at'    => 'Created At',
          'date_range'    => 'Search By Dates',
          'options'       => 'Options',
          'status'        => 'Status',
          'title'         => 'Title',
      ],
      'routes'     => [
          'create' => 'Create Qualifications',
          'index' => 'Qualifications',
          'update' => 'Update Qualification',
      ],
      'validation'=> [
          'description'   => [
              'required'  => 'Please enter the description of Qualification',
          ],
          'title'         => [
              'required'  => 'Please enter the title of Qualification',
              'unique'    => 'This title Qualification is taken before',
          ],
      ],
    ],
];
