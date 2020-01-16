<?php

namespace Supplycart\Xero\Actions;

use Supplycart\Xero\Contracts\ShouldCheckConnection;

class UpdatePurchaseOrder extends Action implements ShouldCheckConnection
{
    public function handle(string $poNumber, array $data)
    {
        $this->log(__CLASS__ . ': START');

        $response = $this->xero->client->get(
            "https://api.xero.com/api.xro/2.0/PurchaseOrders/{$poNumber}",
            [
                'query' => [
                    'SummarizeErrors' => 'false',
                ],
                'json' => $data,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                    'xero-tenant-id' => $this->xero->storage->getTenantID(),
                ],
            ]
        );

        $response = json_decode($response->getBody()->getContents());

        $this->log('response', (array) $response);

        $this->log(__CLASS__ . ': ENDS');
    }
}
