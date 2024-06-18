<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;

use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\PurchaseOrder\PurchaseOrder;

class UpdatePurchaseOrder extends Action implements ShouldCheckConnection
{
    public function handle(PurchaseOrder $purchaseOrder)
    {
        try {
            if (empty($purchaseOrder->PurchaseOrderID)) {
                return false;
            }

            $response = $this->xero->client->post(
                "https://api.xero.com/api.xro/2.0/PurchaseOrders/{$purchaseOrder->PurchaseOrderID}",
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

            return new PurchaseOrder((array) data_get($data, 'PurchaseOrders.0'));
        } catch (ClientException | Exception $ex) {
            $this->logError(self::class . ': ' . $ex->getMessage());
            throw $ex;
        }
    }
}
