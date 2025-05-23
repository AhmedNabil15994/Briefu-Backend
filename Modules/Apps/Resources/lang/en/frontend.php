<?php

return [
    'contact_us' => [
        'alerts' => [
            'send_message' => 'Message Sent Successfully',
        ],
        'form' => [
            'btn' => [
                'send' => 'Send',
            ],
            'email' => 'Email',
            'message' => 'Message',
            'mobile' => 'Mobile',
            'username' => 'Name',
        ],
        'info' => [
            'email' => 'Email address',
            'mobile' => 'Mobile',
            'address' => 'Address',
            'title' => 'Information',
            'our_site' => 'Our Site',
            'technical_support' => 'Technical Support',
        ],
        'mail' => [
            'header' => 'We received new contact us mail',
            'subject' => 'Contact Us Mail',
        ],
        'title' => 'Contact Us',
        'title_2' => 'Send message for us',
        'header_title' => 'Contact Us',
        'validations' => [
            'email' => [
                'email' => 'Please enter correct email',
                'required' => 'Please enter the email address',
            ],
            'message' => [
                'min' => 'Message must be more than 10 characters',
                'required' => 'Please fill the message of contact us',
                'string' => 'please enter only characters and numbers in message',
            ],
            'mobile' => [
                'digits_between' => 'You must enter mobile number with 8 digits',
                'numeric' => 'Please enter correct mobile number',
                'required' => 'Please enter mobile number',
            ],
            'username' => [
                'min' => 'Name must be more than 3 character',
                'required' => 'Please enter Name',
                'string' => 'Please enter Name with only characters and numbers',
            ],
        ],
    ],
];
