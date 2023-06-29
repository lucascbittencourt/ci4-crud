<?php

return [
    'required' => 'The {field} is required.',
    'valid_email' => 'The email "{value}" is invalid!',
    'user' => [
        'username' => [
            'unique' => 'Sorry. The username: "{value}" has been taken by other user. Try other.'
        ],
        'email' => [
            'unique' => 'Sorry. The email: "{value}" has been used by other user.'
        ],
        'mobile' => [
            'unique' => 'Sorry. That mobile number has been used by other user.',
        ],
        'password_confirm' => [
            'required_with' => 'You must confirm your new password.',
            'matches' => 'The password confirmation should match with the password.',
        ],
    ]
];
