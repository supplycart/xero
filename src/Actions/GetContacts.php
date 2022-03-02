<?php

namespace Supplycart\Xero\Actions;

use Exception as Exception;
use Spatie\DataTransferObject\DataTransferObjectError;
use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Contact\ContactCollection;

class GetContacts extends Action implements ShouldCheckConnection
{
    /**
     * @param array $params
     *
     * @return \Supplycart\Xero\Data\Contact\ContactCollection
     */
    public function handle(array $params = [])
    {
        try {
            $defaultParams = [
                'IsSupplier' => 'true',
            ];

            $whereParam = urldecode(http_build_query(array_merge($defaultParams, $params), '=', ' AND '));

            $response = $this->xero->client->get('https://api.xero.com/api.xro/2.0/Contacts', [
                'query' => [
                    'SummarizeErrors' => 'false',
                    'Where' => $whereParam,
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                    'Xero-tenant-id' => $this->xero->storage->getTenantID(),
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());

            return new ContactCollection(data_get($data, 'Contacts', []));
        } catch (DataTransferObjectError $ex) {
            throw new Exception(sprintf('%s: Line: %s, Error: %s', get_class($ex), $ex->getLine(), $ex->getMessage()));
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
