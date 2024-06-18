<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;

use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\PurchaseOrder\PurchaseOrder;

class GetPurchaseOrder extends Action implements ShouldCheckConnection
{
    /**
     * @return \Supplycart\Xero\Data\PurchaseOrder\PurchaseOrder
     */
    public function handle(string $poNumber)
    {
        try {
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

            return new PurchaseOrder((array) data_get($data, 'PurchaseOrders.0'));
        } catch (ClientException | Exception $ex) {
            $this->logError(self::class . ': ' . $ex->getMessage());
            throw $ex;
        }
    }
}
