<?php
return [
    'defaults' => [
        'guard' => 'user'
    ],
    'guards' => [
        'user' => [
            'driver' => 'jwt',
            'provider' => 'users'
        ]
    ],
    'providers' => [
        'users' => [
            'model' => \App\Models\User::class,
        ]
    ]
];
