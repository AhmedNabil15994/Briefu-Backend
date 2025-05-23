<?php

return [
    'courses' => [
      'form'  => [
          'description'       => 'Description',
          'restore'           => 'Restore from trash',
          'meta_description'  => 'Meta Description',
          'meta_keywords'     => 'Meta Keywords',
          'status'            => 'Status',
          'title'             => 'Title',
          'image'             => 'Image',
          'price'             => 'Price',
          'type'              => 'In footer',
          'categories'        => 'Categories',
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
          'create' => 'Create Courses',
          'index' => 'Courses',
          'update' => 'Update Course',
      ],
      'validation'=> [
          'description'   => [
              'required'  => 'Please enter the description of course',
          ],
          'title'         => [
              'required'  => 'Please enter the title of course',
              'unique'    => 'This title course is taken before',
          ],
      ],
    ],

    'course_orders' => [
        'datatable' => [
            'created_at'    => 'Created at',
            'options'       => 'Options',
            'status'        => 'Status',
            'cvs'           => 'Submited CVS ( Number )',
            'title'         => 'Course Title',
            'user'          => 'User CV',
            'mobile'          => 'Mobile',
            'companies'     => 'Company'
        ],
        'form'      => [
            'status'    => 'Status',
            'tabs'      => [
                'course'   => 'Job Description',
                'course_orders'   => 'User Requested course'
            ],
            'courses'   => 'Course & Certifications',
            'from'   => 'Start Date',
            'to'   => 'End Date',
            'loading'   => 'Loading',
            'not_have_video_cv'   => 'Not have video CV',
            'target'        => 'targeted job',
            'address'   => 'From',
            'company'   => 'Company',
            'company_address'   => 'Company Address',
            'position'   => 'Position',
            'hrs'   => 'Hrs',
            'experiences'   => 'Experiences',
            'video_cv'   => 'Video CV',
            'open'   => 'Download / Open Video',
            'title'     => 'Title',
            'nationality'   => 'Nationality',
            'description'   => 'Description',
            'cv_pdf'       => 'Cv pdf',
            'state'         => 'State'
        ],
        'routes'    => [
            'create'    => 'Create Course Order',
            'index'     => 'Course Order',
            'show'      => 'User Requested Course',
            'update'    => 'Update Course Order',
        ],
        'validation'=> [
            'title' => [
                'required'  => 'Please add title for this job',
                'unique'    => 'This title is taken before',
            ],
        ],
    ],
];
