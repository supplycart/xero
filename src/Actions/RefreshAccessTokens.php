<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;


class RefreshAccessTokens extends Action
{
    public function handle()
    {
        /** @var \Supplycart\Xero\Xero $xero */
        $xero = $this->xero->storage->refresh();

        try {
            $response = $this->xero->client->post('https://identity.xero.com/connect/token', [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($this->xero->config('oauth2.client_id') . ':' . $this->xero->config('oauth2.client_secret')),
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
        } catch (ClientException $ex) {
            // Reset XERO "enabled" state if the refresh token has expired or become invalid
            // So that it would throw the error only once since token refresh only perform on "enabled" XERO connections
            if (in_array($ex->getCode(), [
                Response::HTTP_BAD_REQUEST,
                Response::HTTP_UNAUTHORIZED,
                Response::HTTP_FORBIDDEN,
            ])) {
                $xero->setAccessToken(null);
                $xero->setRefreshToken(null);
                $xero->is_enabled = false;
                $xero->persist();
            }

            $this->logError(self::class . ': ' . $ex->getMessage());
            throw $ex;
        } catch (Exception $ex) {
            $this->logError(self::class . ': ' . $ex->getMessage());
            throw $ex;
        }

        return true;
    }
}
