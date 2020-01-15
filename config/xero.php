<?php

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
        'redirect_path' => env('XERO_REDIRECT_PATH', '/xero/oauth2/redirect'),
        'scope' => env('XERO_SCOPE',
            'offline_access openid profile email accounting.transactions accounting.contacts accounting.settings'),
        'authorize_url' => 'https://login.xero.com/identity/connect/authorize',
        'access_token_url' => 'https://identity.xero.com/connect/token',
        'resource_owner_details_url' => 'https://api.xero.com/api.xro/2.0/Organisation',
    ],
    'log_channel' => env('XERO_LOG_CHANNEL', 'xero'),
];
