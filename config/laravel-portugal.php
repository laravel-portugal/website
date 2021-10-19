<?php

return [
    'social' => [
        'twitter' => 'https://twitter.com/LaravelPortugal',
        'github' => 'https://github.com/laravel-portugal',
        'meetup' => 'https://www.meetup.com/pt-BR/Laravel-Portugal/',
        'discord' => 'https://discord.gg/9medAV2mD5',
    ],

    'crawler' => [
        'user-agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
    ],

    'browserShot' => [
        'args' => [
            // Required for Docker version of Puppeteer
            'no-sandbox',
            'disable-setuid-sandbox',
            // This will write shared memory files into /tmp instead of /dev/shm,
            // because Docker’s default for /dev/shm is 64MB
            'disable-dev-shm-usage',
        ],
        'options' => [
            'node_binary' => env('BROWSER_SHOT_NODE_BINARY', '/usr/bin/node'),
            'npm_binary' => env('BROWSER_SHOT_NPM_BINARY', '/usr/bin/npm'),
        ],
    ],

    'links' => [
        // Max in characters for title and description & image size
        'title_max_size' => '120',
        'description_max_size' => '200',
        'cover_image_max_size' => '2500', // kb

        // Storage and folder to use
        'storage' => [
            'disk' => 'public',
            'path' => 'links-cover-images',
        ],

        // Crop & Format images into this.
        'cover_image' => [
            'size' => [
                'w' => 1200,
                'h' => 630,
            ],
            'format' => 'jpeg',
            'quality' => 90,
        ],
    ],

    'oauth-providers' => [
        'discord',
        'github',
        'twitter',
    ],
];
