<?php
return [
    // select between: file, redis
    'driver' => $_ENV['CACHE_DRIVER'] ?? 'file',

    'drivers' => [
        'file' => [
            'path' => basePath('storage/core/cache'),
            'namespace' => '',
            'lifetime' => 3600,
        ],
    ],
];
