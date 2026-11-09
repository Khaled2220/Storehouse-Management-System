<?php

return [
    'admin' => [
        'email' => env('ADMIN_EMAIL', 'admin@example.com'),
        'password' => env('ADMIN_SEED_PASSWORD'),
    ],

    'user' => [
        'email' => env('SEED_USER_EMAIL', 'user@example.com'),
        'password' => env('SEED_USER_PASSWORD'),
    ],
];
