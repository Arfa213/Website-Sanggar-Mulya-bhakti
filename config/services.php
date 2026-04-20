<?php

return [

    'postmark' => ['key' => env('POSTMARK_API_KEY')],
    'resend'   => ['key' => env('RESEND_API_KEY')],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // Gemini AI untuk chatbot — daftar API key gratis di: https://aistudio.google.com/app/apikey
    // Tambahkan di .env: GEMINI_API_KEY=AIzaSy...
    'gemini' => [
        'key' => env('GEMINI_API_KEY', ''),
    ],

];
