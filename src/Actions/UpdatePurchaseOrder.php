<?php

namespace Supplycart\Xero\Actions;

use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\PurchaseOrder\PurchaseOrder;

class UpdatePurchaseOrder extends Action implements ShouldCheckConnection
{
    public function handle(PurchaseOrder $purchaseOrder)
    {
        $this->log(__CLASS__ . ': START');

        if (empty($purchaseOrder->PurchaseOrderNumber)) {
            return false;
        }

        $response = $this->xero->client->post(
            "https://api.xero.com/api.xro/2.0/PurchaseOrders/{$purchaseOrder->PurchaseOrderNumber}",
            [
                'query' => [
                    'SummarizeErrors' => 'false',
                ],
                'json' => $purchaseOrder->toArray(),
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                    'xero-tenant-id' => $this->xero->storage->getTenantID(),
                ],
            ]
        );

        $data = (array) json_decode($response->getBody()->getContents());

        $this->log(__CLASS__ . ': ENDS');

        return new PurchaseOrder((array) data_get($data, 'PurchaseOrders.0'));
    }
}
