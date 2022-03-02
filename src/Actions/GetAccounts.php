<?php

namespace Supplycart\Xero\Actions;

use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Account\AccountCollection;

class GetAccounts extends Action implements ShouldCheckConnection
{
    /**
     * @param array $params
     *
     * @return \Supplycart\Xero\Data\Contact\AccountCollection
     */
    public function handle(array $params = [])
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
                ],
            ]);

            $data = (array) json_decode($response->getBody()->getContents());

            return new AccountCollection((array) data_get($data, 'Accounts'));
        } catch (DataTransferObjectError $ex) {
            throw new Exception(sprintf('%s: Line: %s, Error: %s', get_class($ex), $ex->getLine(), $ex->getMessage()));
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
