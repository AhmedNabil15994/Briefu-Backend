<?php

return [
    'validations' => [
        'consultation' => [
            'required' => 'Consultation required',
            'you_are_already_asked_your_consultation' => 'You already submitted a consultation request',
        ]
    ],
    'users' => [
        'user_blocked' => 'Your account has been blocked',
        'otp' => [
            'messages' => [
                'otp_is_expired_resend_again' => 'Your OTP  is expired , Try resend again',
                'your_otp_is_wrong' => 'Your OTP is wrong',
                'your_otp_is' => 'Your OTP is : ',
                'we_are_send_otp_to_verify_your_phone' => 'We are send OTP to Verify your Mobile',
            ],
        ],
        'validation'    => [
            'current_password'  => [
                'required'  => 'Current password is required',
                'not_match'  => 'Current password is wrong',
            ],
            'email'             => [
                'required'  => 'Please enter the email of user',
                'unique'    => 'This email is taken before',
            ],
            'mobile'            => [
                'digits_between'    => 'Please add mobile number only 8 digits',
                'numeric'           => 'Please enter the mobile only numbers',
                'required'          => 'Please enter the mobile of user',
                'unique'            => 'This mobile is taken before',
            ],
            'name'              => [
                'required'  => 'Please enter the name of user',
            ],
            'otp'              => [
                'required'  => 'Please enter the OTP',
            ],
            'password'          => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'Please enter the password of user',
                'same'      => 'The Password confirmation not matching',
            ],
        ],
    ],
];
