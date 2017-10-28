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
        'client_id'     => '5TfdZ1TCP0pucnkG3MmZmYvlg',
        'client_secret' => '8V4Kg15hD9pQ0hNgn6SXRELqvfYx1o5mgXhrQMeDVirE1zCeOA',
        'redirect'      => 'http://yyux.jp/login/callback/twitter',
    ],

    'facebook' => [
        'client_id'     => '1106808152774436',
        'client_secret' => '1d3e517fece96baff6c688252cdb9291',
        'redirect'      => 'http://yyux.jp/login/callback/facebook',
    ],

    'google' => [
        'client_id'     => '539410671293-un7kv7bi8fgis1ovkdrj8biv7nmvkl9e.apps.googleusercontent.com',
        'client_secret' => 'tH8lcPh2AM4TpbgRkhB2VTf5',
        'redirect'      => 'http://yyux.jp/login/callback/google',
    ],

    'github' => [
        'client_id'     => '501d8249ec8fe5c2461f',
        'client_secret' => 'e956456db93648161446a61b4ecfc17455a611f5',
        'redirect'      => 'http://yyux.jp/login/callback/github',
    ],


];
