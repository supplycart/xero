<?php

namespace Supplycart\Xero\Actions;

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
        $this->log(__CLASS__ . ': START');

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

        $this->log(__CLASS__ . ': END');

        return new Bill((array) data_get($data, 'Invoices.0'));
    }
}
