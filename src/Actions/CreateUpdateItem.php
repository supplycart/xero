<?php

namespace Supplycart\Xero\Actions;

use Supplycart\Xero\Data\Item\Item;
use Illuminate\Foundation\Bus\Dispatchable;
use Supplycart\Xero\Contracts\ShouldCheckConnection;

class CreateUpdateItem extends Action implements ShouldCheckConnection
{
    use Dispatchable;

    /**
     * @var array
     */
    private $data;

    public function handle(Item $data)
    {
        $this->log(__CLASS__ . ': START');

        $response = $this->xero->client->post(
            'https://api.xero.com/api.xro/2.0/Items',
            [
                'query' => [
                    'SummarizeErrors' => 'false',
                ],
                'json' => $data->toArray(),
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                    'xero-tenant-id' => $this->xero->storage->getTenantID(),
                ],
            ]
        );

        $data = (array) json_decode($response->getBody()->getContents());

        $this->log(__CLASS__ . ': END');

        return new Item((array) data_get($data, 'Items.0'));
    }
}
