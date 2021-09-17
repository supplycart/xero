<?php

namespace Supplycart\Xero\Actions;

use GuzzleHttp\Exception\ClientException;
use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Currency\CurrencyCollection;

class GetCurrencies extends Action implements ShouldCheckConnection
{
    public function handle()
    {
        $response = $this->xero->client->get('https://api.xero.com/api.xro/2.0/Currencies', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                'Xero-tenant-id' => $this->xero->storage->getTenantID(),
            ],
        ]);

        $data = json_decode($response->getBody()->getContents());

        return new CurrencyCollection(data_get($data, 'Currencies', []));
    }
}
