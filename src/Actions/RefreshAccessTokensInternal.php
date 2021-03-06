<?php

namespace Supplycart\Xero\Actions;

use GuzzleHttp\Exception\ClientException;

class RefreshAccessTokensInternal extends Action
{
    public function handle()
    {
        $this->log(__CLASS__ . ': START');

        /** @var \Supplycart\Xero\Xero $xero */
        $xero = $this->xero->storage->refresh();

        try {
            $response = $this->xero->client->post('https://identity.xero.com/connect/token', [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($this->xero->config('oauth2_internal.client_id') . ':' . $this->xero->config('oauth2_internal.client_secret')),
                ],
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $xero->getRefreshToken(),
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());

            $xero->setAccessToken(data_get($data, 'access_token'));
            $xero->setRefreshToken(data_get($data, 'refresh_token'));
            $xero->setExpiredAt(now()->addSeconds(data_get($data, 'expires_in')));
            $xero->persist();
        } catch (ClientException $e) {
            if($xero->getExpiredAt()->diffInDays(now()) >= 60) {
                $xero->setAccessToken(null);
                $xero->setRefreshToken(null);
                $xero->persist();

                $this->log('XERO disconnected!');
            }
            
            return false;
        }

        $this->log(__CLASS__ . ': END');

        return true;
    }
}
