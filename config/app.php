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
        'prefix' => 'niuncms'
    ],
    'pathsToTemplates' => [
        __DIR__ . '/../app/Views'
    ],
    'pathToCompiledTemplates' => __DIR__ . '/../storage/templates_c'
];