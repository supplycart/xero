<?php

namespace Supplycart\Xero\Actions;

use Exception;
use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Invoice\Invoice;

class CreateInvoice extends Action implements ShouldCheckConnection
{
    public function handle(Invoice $data)
    {
        try {
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

            $invoiceData = data_get($data, 'Invoices.0');
            return new Invoice(json_decode(json_encode($invoiceData), true));
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
