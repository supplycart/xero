<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Spatie\DataTransferObject\DataTransferObjectError;

class RefreshAccessTokensInternal extends Action
{
    public function handle()
    {
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
        } catch (DataTransferObjectError | Exception $ex) {
            $this->logError(__CLASS__ . ': ' . $ex->getMessage());
            throw $ex;
        } catch (ClientException $ex) {
            if ($xero->getExpiredAt()->diffInDays(now()) >= config('xero.token_expired_days')) {
                $xero->setAccessToken(null);
                $xero->setRefreshToken(null);
                $xero->persist();
            }

            $this->logError(__CLASS__ . ': ' . $ex->getMessage());
            throw $ex;
        }

        return true;
    }
}
