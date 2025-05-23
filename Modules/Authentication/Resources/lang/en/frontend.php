<?php
return [
    'password' => [
        'mail' => [
            'subject' => 'Reset Password',
        ],
        'messages' => [
            'success' => 'Reset Password Send Successfully',
            'updated_success' => 'Your Password Updated Successfully',
        ],
    ],
    'reset' => [
        'mail' => [
            'button_content' => 'Reset Your Password',
            'header' => 'You are receiving this email because we received a password reset request for your account.',
            'subject' => 'Reset Password',
        ],
        'title' => 'Reset Password',
        'validation' => [
            'email' => [
                'email' => 'Please enter correct email format',
                'exists' => 'this email does not exist ',
                'required' => 'The email field is required',
            ],
            'password' => [
                'min' => 'Password must be more than 6 characters',
                'required' => 'The password field is required',
                'confirmed' => 'The password field not confirmed ',
            ],
            'token' => [
                'exists' => 'This token expired',
                'required' => 'The token field is required',
            ],
        ],
    ],
];