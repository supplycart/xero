<?php

namespace Supplycart\Xero\Actions;

use Supplycart\Xero\Contracts\ShouldCheckConnection;

class GetPurchaseOrder extends Action implements ShouldCheckConnection
{
    public function handle(string $poNumber)
    {
        $response = $this->xero->client->get(
            "https://api.xero.com/api.xro/2.0/PurchaseOrders/{$poNumber}",
            [
                'query' => [
                    'SummarizeErrors' => 'false',
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                    'xero-tenant-id' => $this->xero->storage->getTenantID(),
                ],
            ]
        );

        $data = (array) json_decode($response->getBody()->getContents());

        $this->log($data);

        return $data;
    }
}
