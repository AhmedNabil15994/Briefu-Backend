<?php

return [
    'jobs' => [
        'filter' => [
            'status' => 'Status'
        ],
        'datatable' => [
            'created_at' => 'Created at',
            'options' => 'Options',
            'title' => 'Title',
            'status' => 'Status',
            'company' => 'Company',
            'cvs' => 'Number Of Submitted Cvs',
        ],
        'form' => [
            'status' => 'Status',
            'related_courses' => 'Categories of courses related with this job',
            'tabs' => [
                'general' => 'General Info.',
                'attributes' => 'Job Attribute'
            ],
            'title' => 'Title',
            'description' => 'Description',
            'cities' => 'cities',
            'company' => 'Company',
            'subscription_access' => 'Pro Subscription access',
            'state' => 'State'
        ],
        'routes' => [
            'create' => 'Create Jobs',
            'index' => 'Jobs',
            'update' => 'Update Jobs',
            'show' => 'Show Submitted Cvs'
        ],
        'validation' => [
            'title' => [
                'required' => 'Please add title for this job',
                'unique' => 'This title is taken before',
            ],
            'company_id' => [
                'required' => 'Please select company',
                'unique' => 'Please select company',
                'company_not_have_subscription' => 'Company not have subscription',
            ],
        ],
    ],

    'cvs' => [
        'datatable' => [
            'created_at' => 'Created at',
            'options' => 'Options',
            'status' => 'Status',
            'cvs' => 'Submitted CVS ( Number )',
            'title' => 'Job Title',
            'user' => 'User CV',
            'companies' => 'Company',
            'jobs' => 'Jobs',
        ],
        'form' => [
            'status' => 'Status',
            'tabs' => [
                'job' => 'Job Description',
                'update_request' => 'Update request',
                'cvs' => 'Submitted CVS'
            ],
            'courses'   => 'Course & Certifications',
            'from' => 'Start Date',
            'to' => 'End Date',
            'target' => 'targeted job',
            'is_special' => 'special needs',
            'yes' => 'Yes',
            'no' => 'No',
            'graduation_info' => 'education info',
            'qualification' => 'Qualification',
            'fresh_graduate' => 'Fresh Graduate',
            'graduate_year' => 'Graduate year',
            'faculty' => 'university',
            'major' => 'Major',
            'country_of_residence' => 'Country of residence',
            'until_now' => 'Until now',
            'address' => 'Training institute',
            'address_from' => 'From',
            'qualifications' => 'Qualifications',
            'nationality' => 'Nationality',
            'gender' => 'Gender',
            'marital_status' => 'Marital Status',
            'not_have_video' => 'Not have video',
            'not_have_pdf' => 'Not have PDF CV',
            'video' => 'Video',
            'company' => 'Company',
            'company_address' => 'Company Address',
            'position' => 'Position',
            'hrs' => 'Hrs',
            'experiences' => 'Experiences',
            'video_cv' => 'Video CV',
            'pdf_cv' => 'PDF CV',
            'open' => 'Download / Open Video',
            'open_pdf' => 'Download / Open PDF',
            'title' => 'Title',
            'description' => 'Description',
            'cv_status' => 'CV status',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'b_day' => 'Birthday',
            'cv_status_options' => [
                'new' => 'New',
                'shortlisted' => 'Shortlisted',
                'under_review' => 'Under_review',
                'approved' => 'Approved',
                'rejected' => 'Rejected'
            ],
            'state' => 'State'
        ],
        'routes' => [
            'create' => 'Create Jobs',
            'index' => 'Jobs',
            'show' => 'Submitted CVS',
            'update' => 'Update Jobs',
        ],
        'validation' => [
            'title' => [
                'required' => 'Please add title for this job',
                'unique' => 'This title is taken before',
            ],
        ],
    ],
];
