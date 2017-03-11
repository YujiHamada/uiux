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
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'twitter' => [
        'client_id'     => 'MrdQ6QOEI7mYT5Gm9DbaqFxoH',
        'client_secret' => '31waOHOEai1CYslgdqB5mZXfvha5T8oeY4sxppcusl0V177I5s',
        'redirect'      => 'http://uiux.com/login/callback/twitter',
    ],

    'facebook' => [
        'client_id'     => '1106808152774436',
        'client_secret' => '1d3e517fece96baff6c688252cdb9291',
        'redirect'      => 'http://uiux.com/login/callback/facebook',
    ],

    'google' => [
        'client_id'     => '242343756819-tr69or56vs3qf15mfddgot3kq6rvosnl.apps.googleusercontent.com',
        'client_secret' => 'y2er4THlouZvr5VfxuMxKlco',
        'redirect'      => 'http://uiux.com/login/callback/google',
    ],

    'github' => [
        'client_id'     => '501d8249ec8fe5c2461f',
        'client_secret' => 'e956456db93648161446a61b4ecfc17455a611f5',
        'redirect'      => 'http://uiux.com/login/callback/github',
    ],


];
