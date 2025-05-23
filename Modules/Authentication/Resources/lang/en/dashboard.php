<?php

return [
    'login' => [
        'form'          => [
            'btn'       => [
                'login' => 'Login Now',
                'reset_password' => 'reset password',
            ],
            'email'     => 'ِEmail address',
            'password'  => 'Password',
            'password_confirmation'  => 'password confirmation',
        ],
        'routes'        => [
            'index' => 'Login',
            'reset_password' => 'Reset password',
        ],
        'validations'   => [
            'email'     => [
                'email'     => 'Please add correct email format',
                'required'  => 'Please add your email address',
            ],
            'failed'    => 'These credentials do not match our records.',
            'password'  => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'The password field is required',
            ],
        ],
    ],
];
