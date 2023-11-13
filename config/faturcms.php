<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Package Name
    |--------------------------------------------------------------------------
    |
    */

    'name' => 'campusdigital/campuscms',

    /*
    |--------------------------------------------------------------------------
    | Controllers
    |--------------------------------------------------------------------------
    |
    */

    'controllers' => [
        'namespace' => 'Campusdigital\\CampusCMS\\Http\\Controllers',
    ],

    /*
    |--------------------------------------------------------------------------
    | Images
    |--------------------------------------------------------------------------
    |
    */

    'images' => [
        'acara' => 'acara.png',
        'blog' => 'blog.png',
        'ebook' => 'pdf.svg',
        'fitur' => 'fitur.png',
        'folder' => 'folder.svg',
        'karir' => 'karir.png',
        'mentor' => 'mentor.jpg',
        'gallery' => 'gallery.jpg',
        'mitra' => 'mitra.png',
        'pelatihan' => 'pelatihan.png',
        'program' => 'program.png',
        'script' => 'pencil.svg',
        'slider' => 'slider.png',
        'testimoni' => 'testimoni.jpg',
        'tools' => 'tools.svg',
        'user' => 'user.jpg',
        'video' => 'video.svg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed Access
    |--------------------------------------------------------------------------
    |
    */

    'allowed_access' => [
        'DashboardController::admin',
        'DashboardController::member',
    ]
];
