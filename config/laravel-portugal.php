<?php

return [
    'browserShot' => [
        'args' => [
            // Required for Docker version of Puppeteer
            'no-sandbox',
            'disable-setuid-sandbox',
            // This will write shared memory files into /tmp instead of /dev/shm,
            // because Docker’s default for /dev/shm is 64MB
            'disable-dev-shm-usage',
        ],
    ],
    'links' => [
        'storage' => [
            'path' => 'links_cover_images',
        ],
        'cover_image' => [
            'size' => [
                'w' => 368,
                'h' => 256,
            ],
            'format' => 'jpeg',
            'quality' => 90,
        ],
    ],
];
