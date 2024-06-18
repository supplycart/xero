<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;

use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Account\AccountCollection;

class GetAccounts extends Action implements ShouldCheckConnection
{
    /**
     * @return \Supplycart\Xero\Data\Contact\AccountCollection
     */
    public function handle(array $params = [], ?string $ifModifiedSince = null)
    {
        try {
            $defaultParams = [];

            $whereParam = urldecode(http_build_query(array_merge($defaultParams, $params), '=', ' AND '));

            $response = $this->xero->client->get('https://api.xero.com/api.xro/2.0/Accounts', [
                'query' => [
                    'SummarizeErrors' => 'false',
                    'where' => $whereParam,
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                    'xero-tenant-id' => $this->xero->storage->getTenantID(),
                    'If-Modified-Since' => $ifModifiedSince
                ],
            ]);

            $data = (array) json_decode($response->getBody()->getContents());

            return new AccountCollection((array) data_get($data, 'Accounts'));
        } catch (ClientException | Exception $ex) {
            $this->logError(self::class . ': ' . $ex->getMessage());
            throw $ex;
        }
    }
}
