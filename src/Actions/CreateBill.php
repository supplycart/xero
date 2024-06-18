<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;

use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Invoice\Bill;

class CreateBill extends Action implements ShouldCheckConnection
{
    /**
     * @param Bill $data
     *
     * @return \Supplycart\Xero\Data\Invoice\Bill
     */
    public function handle($data)
    {
        try {
            $response = $this->xero->client->put(
                'https://api.xero.com/api.xro/2.0/Invoices',
                [
                    'query' => [
                        'SummarizeErrors' => 'false',
                        'unitdp' => 4,
                    ],
                    'json' => $data,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                        'xero-tenant-id' => $this->xero->storage->getTenantID(),
                    ],
                ]
            );

            $data = (array) json_decode($response->getBody()->getContents());

            return new Bill((array) data_get($data, 'Invoices.0'));
        } catch (ClientException | Exception $ex) {
            $this->logError(self::class . ': ' . $ex->getMessage());
            throw $ex;
        }
    }
}
