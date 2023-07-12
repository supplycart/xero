<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\DataTransferObject\DataTransferObjectError;
use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\PurchaseOrder\PurchaseOrder;

class CreatePurchaseOrder extends Action implements ShouldCheckConnection
{
    use Dispatchable;

    /**
     * @var array
     */
    private $data;

    /**
     * @param PurchaseOrder $data
     * @return \Supplycart\Xero\Data\PurchaseOrder\PurchaseOrder
     */
    public function handle(PurchaseOrder $data)
    {
        try {
            $response = $this->xero->client->post(
                'https://api.xero.com/api.xro/2.0/PurchaseOrders',
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

            return new PurchaseOrder((array) data_get($data, 'PurchaseOrders.0'));
        } catch (ClientException | DataTransferObjectError | Exception $ex) {
            $this->logError(__CLASS__ . ': ' . $ex->getMessage());
            throw $ex;
        }
    }
}
