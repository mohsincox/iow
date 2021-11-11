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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'google' => [
        // 'client_id' => '124439556740-kh4q19hvriscuh8ro3a3fp69q9ggs090.apps.googleusercontent.com',
        'client_id' => '276105901783-df9vk37mts78tjpe3159l0grvf333o04.apps.googleusercontent.com',
        // 'client_secret' => 'WWw3JlqzfW0wJ0saNw8rDoTS',
        'client_secret' => 'oC_QiuuuNnT1rOceVPWSdY5x',
        // 'redirect' => url('/google-callback')
        'redirect' => 'https://igloobd.com/google-callback',
    ],
    'facebook' => [
        // 'client_id' => '459722771629988',2470918859835873
        // 'client_secret' => '785d6a826f06783fdc827c8d785b73b0',
        'client_id' => '2470918859835873',
        'client_secret' => 'aac6ae488f0f8e6f132fba5e9b1c2f01',
        'redirect' => 'https://igloobd.com/facebook-callback',
    ],

];
