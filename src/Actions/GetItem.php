<?php

namespace Supplycart\Xero\Actions;

use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Item\ItemCollection;

class GetItem extends Action implements ShouldCheckConnection
{
    public function handle(string $sku)
    {
        $response = $this->xero->client->get("https://api.xero.com/api.xro/2.0/Items/{$sku}", [
            'query' => [
                'SummarizeErrors' => 'false',
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                'Xero-tenant-id' => $this->xero->storage->getTenantID(),
            ],
        ]);

        $data = json_decode($response->getBody()->getContents());

        return new ItemCollection(data_get($data, 'Items', []));
    }
}
