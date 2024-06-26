<?php

use Supplycart\Xero\Xero;

return [
    'enabled' => env('XERO_ENABLED', false),
    'api_base_uri' => 'https://api.xero.com',
    'oauth' => [
        'consumer_key' => env('XERO_CONSUMER_KEY', 'key'),
        'consumer_secret' => env('XERO_CONSUMER_SECRET', 'secret'),
        'callback' => '',
        'rsa_private_key' => env('XERO_RSA_KEY_PATH', 'file://PATH_TO_PEM_KEY_FILE'),
    ],
    'oauth2' => [
        'client_id' => env('XERO_CLIENT_ID'),
        'client_secret' => env('XERO_CLIENT_SECRET'),
        'redirect_uri' => env('XERO_REDIRECT_URI', '/xero/oauth2/redirect'),
        'authenticated_uri' => env('XERO_AUTHENTICATED_URI'),
        'scope' => env(
            'XERO_SCOPE',
            'offline_access openid profile email accounting.transactions accounting.contacts accounting.settings accounting.attachments'
        ),
        'authorize_url' => 'https://login.xero.com/identity/connect/authorize',
        'access_token_url' => 'https://identity.xero.com/connect/token',
        'resource_owner_details_url' => 'https://api.xero.com/api.xro/2.0/Organisation',
    ],
    'oauth2_internal' => [
        'client_id' => env('XERO_INTERNAL_CLIENT_ID'),
        'client_secret' => env('XERO_INTERNAL_SECRET'),
        'redirect_uri' => env('XERO_INTERNAL_REDIRECT_URI', '/xero/oauth2/redirect/internal'),
        'authenticated_uri' => env('XERO_INTERNAL_AUTHENTICATED_URI'),
    ],
    'log_channel' => env('XERO_LOG_CHANNEL', 'xero'),
    'debug' => env('XERO_DEBUG', false),
    'xero_model' => Xero::class,

    // Countdown minutes before the refresh token expires
    'token_refresh_countdown' => intval(env('XERO_TOKEN_REFRESH_COUNTDOWN', 5)),

    // Days passed since the token expired
    'token_expired_days' => intval(env('XERO_TOKEN_EXPIRED_DAYS', 60)),

];
