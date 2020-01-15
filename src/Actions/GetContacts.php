<?php

namespace Supplycart\Xero\Actions;

use GuzzleHttp\Exception\ClientException;
use Supplycart\Xero\Contracts\ShouldCheckConnection;

class GetContacts extends Action implements ShouldCheckConnection
{
    public function handle()
    {
        $response = $this->xero->client->get('https://api.xero.com/api.xro/2.0/Contacts', [
            'query' => [
                'SummarizeErrors' => 'false',
                'Where' => 'IsSupplier==true',
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                'Xero-tenant-id' => $this->xero->storage->getTenantID(),
            ],
        ]);

        return data_get(json_decode($response->getBody()->getContents()), 'Contacts', []);
    }
}
