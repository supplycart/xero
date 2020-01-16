<?php

namespace Supplycart\Xero\Actions;

use GuzzleHttp\Exception\ClientException;
use Supplycart\Xero\Data\Token;

class GetToken extends Action
{
    /**
     * @param string $code
     * @return \Supplycart\Xero\Data\Token
     * @throws \Throwable
     */
    public function handle(string $code)
    {
        $this->log(__CLASS__ . ': START');

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

            $data = (array) json_decode($response->getBody()->getContents());

            $this->log($response->getBody()->getContents());
        } catch (ClientException $e) {
            return null;
        }

        $this->log(__CLASS__ . ': END');

        return new Token($data);
    }
}
