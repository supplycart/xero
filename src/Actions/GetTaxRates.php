<?php

namespace Supplycart\Xero\Actions;

class GetTaxRates extends Action
{
    public function handle()
    {
        $response = $this->xero->client->get('https://api.xero.com/api.xro/2.0/TaxRates', [
            'query' => [
                'SummarizeErrors' => 'false',
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                'xero-tenant-id' => $this->xero->storage->getTenantID(),
            ],
        ]);

        $data = json_decode($response->getBody()->getContents());

        return data_get($data, 'TaxRates', []);
    }
}
