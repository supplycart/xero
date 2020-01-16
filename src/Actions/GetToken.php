<?php

namespace Supplycart\Xero\Actions;

use GuzzleHttp\Exception\ClientException;

class GetToken extends Action
{
    public function handle(string $code)
    {
        try {
            $response = $this->xero->client->post(config('xero.oauth2.access_token_url'), [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode(config('xero.oauth2.client_id') . ':' . config('xero.oauth2.client_secret')),
                ],
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => config('xero.oauth2.redirect_uri'),
                ],
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (ClientException $e) {
            return false;
        }
    }
}
