<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'wacserv' => [
        'secret' => env('WACSERV_SECRET'),
        'client_id' => env('WACSERV_CLIENT_ID'),
        'admin_phone_number' => env('WACSERV_ADMIN_PHONE'),
        'api_url' => env('WACSERV_API_URL', 'https://wacserv.usaha-ku.com/api'),

    ],
    'n8n' => [
        'generate_html_url' =>  env('N8N_GENERATE_HTML_URL'),
        'secret' => env('N8N_SECRTET_KEY'),
        'publish_url' => env('N8N_PUBLISH_WEB_URL'),
    ],

    'price_points' => env('PRICE_POINTS', 50000), // Harga per 5 poin
    'using_points' => env('USING_POINTS', 3), // Poin yang

];
