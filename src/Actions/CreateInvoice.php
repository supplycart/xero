<?php

namespace Supplycart\Xero\Actions;

use Supplycart\Xero\Contracts\ShouldCheckConnection;

class CreateInvoice extends Action implements ShouldCheckConnection
{
    public function handle(array $data)
    {
        $this->log(__CLASS__ . ': START');

        $response = $this->xero->client->post('https://api.xero.com/api.xro/2.0/Invoices', [
            'query' => [
                'SummarizeErrors' => 'false',
            ],
            'json' => $data,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                'xero-tenant-id' => $this->xero->storage->getTenantID(),
            ],
        ]);

        $data = (array) json_decode($response->getBody()->getContents());

        $this->log(__CLASS__ . ': END');

        return $data;
    }
}
