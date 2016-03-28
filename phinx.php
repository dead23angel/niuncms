<?php

use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

$env = new Dotenv(__DIR__);
$env->load();

// Load the helpers
require_once __DIR__ . '/app/helpers.php';

return [
    'paths' => [
        'migrations' => 'database/migrations',
        'seeds'      => 'database/seeds'
    ],
    'migration_base_class' => '\App\Migrations',
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_database' => 'dev',
        'dev' => [
            'adapter' => env('DB_CONNECTION', 'mysql'),
            'host' => env('DB_HOST', 'localhost'),
            'name' => env('DB_DATABASE'),
            'user' => env('DB_USERNAME'),
            'pass' => env('DB_PASSWORD'),
            'port' => 3306
        ]
    ]
];