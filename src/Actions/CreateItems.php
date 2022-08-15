<?php

namespace Supplycart\Xero\Actions;

use Exception;
use Supplycart\Xero\Data\Item\Item;
use Illuminate\Foundation\Bus\Dispatchable;
use Supplycart\Xero\Contracts\ShouldCheckConnection;

class CreateItems extends Action implements ShouldCheckConnection
{
    use Dispatchable;

    /**
     * @var array
     */
    private $data;

    public function handle(array $data)
    {
        try {
            $this->log(__CLASS__ . ': START');

            $response = $this->xero->client->put(
                'https://api.xero.com/api.xro/2.0/Items',
                [
                    'query' => [
                        'SummarizeErrors' => 'false',
                    ],
                    'json' => [
                        'Items' => $data,
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                        'xero-tenant-id' => $this->xero->storage->getTenantID(),
                    ],
                ]
            );

            $data = (array) json_decode($response->getBody()->getContents());

            $this->log(__CLASS__ . ': END');

            $items = [];
            foreach (data_get($data, 'Items', []) as $itemData) {
                $items[] = new Item((array) $itemData);
            }
            return $items;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
