<?php

return [
    'app' => [
        'siteName' => 'Torch Config',
        'user' => 'Slim'
    ],
    'cache' => [
        'default' => 'file',
        'stores.file' => [
            'driver' => 'file',
            'path' => __DIR__ . '/../storage/cache'
        ],
        'stores.redis' => [
            'driver' => 'redis',
            'connection' => 'default'
        ],
        'prefix' => 'niuncms',
        'database.redis' => [
            'cluster' => false,
            'default' => [
                'host' => '127.0.0.1',
                'port' => 6379,
                'database' => 0,
            ],
        ]
    ],
    'pathsToTemplates' => [
        __DIR__ . '/../app/Views'
    ],
    'pathToCompiledTemplates' => __DIR__ . '/../storage/templates_c'
];