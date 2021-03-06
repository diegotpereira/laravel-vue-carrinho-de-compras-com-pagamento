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

    //'postmark' => [
    //    'token' => env('POSTMARK_TOKEN'),
    //],

    //'ses' => [
    //    'key' => env('AWS_ACCESS_KEY_ID'),
    //    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    //    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    //],
	'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],
	'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
	'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
	'passport' => [
        'login_endpoint' => env('PASSPORT_LOGIN_ENDPOINT'),
        'client_id' => env('PASSPORT_CLIENT_ID'),
        'client_secret' => env('PASSPORT_CLIENT_SECRET'),
    ],
	//'passport' => [
    //    'login_endpoint'  => env('TOKEN_LOGIN_ENDPOINT'),
    //    'client_id'    => env('TOKEN_CLIENT_ID'),
    //    'client_secret' => env('TOKEN_CLIENT_SECRET'),
    //],

];
