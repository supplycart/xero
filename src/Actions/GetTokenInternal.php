<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;

use Supplycart\Xero\Data\Token;

class GetTokenInternal extends Action
{
    /**
     * @return \Supplycart\Xero\Data\Token
     * @throws \Throwable
     */
    public function handle(string $code)
    {
        try {
            $response = $this->xero->client->post(config('xero.oauth2.access_token_url'), [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode(config('xero.oauth2_internal.client_id') . ':' . config('xero.oauth2_internal.client_secret')),
                ],
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => config('xero.oauth2_internal.redirect_uri'),
                ],
            ]);

            $data = (array) json_decode($response->getBody()->getContents());

            $this->log($response->getBody()->getContents());
        } catch (ClientException | Exception $ex) {
            $this->logError(self::class . ': ' . $ex->getMessage());
            throw $ex;
        }

        return new Token($data);
    }
}
