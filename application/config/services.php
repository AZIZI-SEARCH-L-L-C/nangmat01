<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => AziziSearchEngineStarter\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'enabled'           =>  getenv('FB_ENABLED', false),
        'client_id'         =>  getenv('FB_ID'),
        'client_secret'     =>  getenv('FB_SECRET'),
        'redirect'          =>  getenv('FB_REDIRECT_TO'),
    ],   

    'twitter' => [
        'enabled'           =>  getenv('TW_ENABLED', false),
        'client_id'         =>  getenv('TW_ID'),
        'client_secret'     =>  getenv('TW_SECRET'),
        'redirect'          =>  getenv('TW_REDIRECT_TO'),
    ],    

    'google' => [
        'enabled'           =>  getenv('GO_ENABLED', false),
        'client_id'         =>  getenv('GO_ID'),
        'client_secret'     =>  getenv('GO_SECRET'),
        'redirect'          =>  getenv('GO_REDIRECT_TO'),
    ],  

];
