<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Client ID
    |--------------------------------------------------------------------------
    |
    | This it your application client id.
    |
    */

    'id' => env('GITHUB_CLIENT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Client Secret
    |--------------------------------------------------------------------------
    |
    | This is your application client secret.
    |
    */

    'secret' => env('GITHUB_CLIENT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Redirection URL
    |--------------------------------------------------------------------------
    |
    | This is where github sends people to after authenticating.
    |
    */

    'redirect' => env('APP_URL').'/auth/github-callback',

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    |
    | The scopes lists attached to the token that we need granted by the user.
    |
    */

    'scopes' => ['admin:repo_hook', 'public_repo', 'read:org', 'user:email'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Users
    |--------------------------------------------------------------------------
    |
    | This defines list of allowed users. Empty means allow everyone.
    |
    | Default to [].
    |
    */

    'allowed' => [],

];
