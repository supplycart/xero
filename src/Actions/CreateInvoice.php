<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;

use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Invoice\Invoice;

class CreateInvoice extends Action implements ShouldCheckConnection
{
    public function handle(Invoice $data)
    {
        try {
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

            $invoiceData = data_get($data, 'Invoices.0');
            return new Invoice(json_decode(json_encode($invoiceData), true));
        } catch (ClientException | Exception $ex) {
            $this->logError(self::class . ': ' . $ex->getMessage());
            throw $ex;
        }
    }
}
