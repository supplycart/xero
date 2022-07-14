<?php

namespace Supplycart\Xero\Actions;

use Exception;
use Spatie\DataTransferObject\DataTransferObjectError;
use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Item\ItemCollection;

class GetItems extends Action implements ShouldCheckConnection
{
    /**
     * @param array $params
     *
     * @return \Supplycart\Xero\Data\Item\ItemCollection
     */
    public function handle(array $params = [], ?string $ifModifiedSince = null)
    {
        try {
            $defaultParams = [];

            $whereParam = urldecode(http_build_query(array_merge($defaultParams, $params), '=', ' AND '));

            $response = $this->xero->client->get('https://api.xero.com/api.xro/2.0/Items', [
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

            $data = json_decode($response->getBody()->getContents());

            return new ItemCollection(data_get($data, 'Items', []));
        } catch (DataTransferObjectError $ex) {
            throw new Exception(sprintf('%s: Line: %s, Error: %s', get_class($ex), $ex->getLine(), $ex->getMessage()));
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
