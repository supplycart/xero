<?php

namespace Supplycart\Xero\Actions;

use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\PurchaseOrder\PurchaseOrder;

class GetPurchaseOrder extends Action implements ShouldCheckConnection
{
    /**
     * @param string $poNumber
     * @return \Supplycart\Xero\Data\PurchaseOrder\PurchaseOrder
     */
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

        return new PurchaseOrder($data);
    }
}
