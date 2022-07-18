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

    'links' => [
        'mtn' => env('MTN_CALLBACK'),
        'voda' => env('VODAFONE_CALLBACK'),
        'vodasub' => env('VODAFONE_STATE'),
        'oauth' => env('OAUTH_TOKEN_LINK'),
        'messaging' => env('MESSAGING_LINK'),
        'charge' => env('CHARGE_LINK'),
        'studio' => env('SMS_STUDIO'),
        'paymentmtn' => env('PAYMENT_MTN'),
        'paymentvodafone' => env('PAYMENT_VODAFONE'),
        'paymenttigo' => env('PAYMENT_TIGO'),
        'paymentstanbic' => env('PAYMENT_STANBIC'),
        'ussdmtn' => env('USSD_MTN'),
        'ussdvodafone' => env('USSD_VODAFONE'),
        'ussdtigo' => env('USSD_TIGO'),
    ],

];
