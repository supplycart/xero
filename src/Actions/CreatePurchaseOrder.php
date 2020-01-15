<?php

namespace Supplycart\Xero\Actions;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Arr;
use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\PurchaseOrder\PurchaseOrder;
use Supplycart\Xero\Exceptions\NoActiveConnectionException;

class CreatePurchaseOrder extends Action implements ShouldCheckConnection
{
    use Dispatchable;

    /**
     * @var array
     */
    private $data;

    /**
     * @param array $data
     * @return string|\Supplycart\Xero\Data\PurchaseOrder\PurchaseOrder
     */
    public function handle(array $data)
    {
        logs()->info(__CLASS__ . ': START');

        $response = $this->xero->client->post(
            'https://api.xero.com/api.xro/2.0/PurchaseOrders',
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

        $purchaseOrder = json_decode($response->getBody()->getContents());

        logs()->info('data', (array) $purchaseOrder);

        logs()->info(__CLASS__ . ': END');

        return $purchaseOrder;
    }
}
