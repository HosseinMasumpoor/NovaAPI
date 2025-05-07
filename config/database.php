<?php
return [
    'default_driver' => 'mysql',

    'drivers' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => $_ENV['DB_HOST'] ?? 'localhost',
            'database'  => $_ENV['DB_NAME'] ?? 'php-auth',
            'username'  => $_ENV['DB_USER'] ?? 'root',
            'password'  => $_ENV['DB_PASS'] ?? '',
            'charset'   => $_ENV['DB_CHARSET'] ?? 'utf8',
            'collation' => $_ENV['DB_COLLATION'] ?? 'utf8_unicode_ci',
            'prefix'    => $_ENV['DB_PREFIX'] ?? '',
        ],
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => __DIR__ . '/../../database.sqlite',
            'prefix' => $_ENV['DB_PREFIX'] ?? '',
        ],
        'pgsql' => [
            'driver' => 'pgsql',
            'host' => $_ENV['DB_HOST'] ?? 'localhost',
            'port' => 5432,
            'database' => $_ENV['DB_NAME'] ?? 'php-auth',
            'username' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASS'] ?? '',
            'charset' => $_ENV['DB_CHARSET'] ?? 'utf8',
            'prefix' => $_ENV['DB_PREFIX'] ?? '',
            'schema' => $_ENV['DB_SCHEMA'] ?? 'public',
        ],
        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => $_ENV['DB_HOST'] ?? 'localhost',
            'database' => $_ENV['DB_NAME'] ?? 'php-auth',
            'username' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASS'] ?? '',
            'prefix' => $_ENV['DB_PREFIX'] ?? '',
        ]
    ],
];
