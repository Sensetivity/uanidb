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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'anime_import' => [
        'rate_limit_delay' => (int) env('ANIME_IMPORT_RATE_LIMIT_DELAY', 2),
        'api_delay' => (int) env('ANIME_IMPORT_API_DELAY', 1),
        'image_download_delay' => (int) env('ANIME_IMPORT_IMAGE_DELAY', 5),
        'sync' => [
            'batch_size' => (int) env('ANIME_SYNC_BATCH_SIZE', 10),
            'interval_minutes' => (int) env('ANIME_SYNC_INTERVAL', 30),
            'min_resync_minutes' => (int) env('ANIME_SYNC_MIN_RESYNC', 10),
            'full_resync_days' => (int) env('ANIME_SYNC_FULL_RESYNC_DAYS', 14),
            'airing_resync_hours' => (int) env('ANIME_SYNC_AIRING_RESYNC_HOURS', 6),
        ],
    ],

    'deepl' => [
        'api_key' => env('DEEPL_API_KEY'),
        'target_language' => env('DEEPL_TARGET_LANGUAGE', 'UK'),
    ],

    'anidb' => [
        'client'     => env('ANIDB_CLIENT', ''),
        'client_ver' => env('ANIDB_CLIENT_VER', '1'),
    ],

];
