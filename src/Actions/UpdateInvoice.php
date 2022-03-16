<?php

namespace Supplycart\Xero\Actions;

use Exception;
use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Invoice\Bill;
use Supplycart\Xero\Data\Invoice\Invoice;

class UpdateInvoice extends Action implements ShouldCheckConnection
{
    /**
     * @param string $invoiceId
     * @param array $data
     *
     * @return Bill|Invoice
     */
    public function handle(string $invoiceId, array $data = [])
    {
        try {
            $this->log(__CLASS__ . ': START');

            $response = $this->xero->client->post(
                "https://api.xero.com/api.xro/2.0/Invoices/{$invoiceId}",
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

            if (data_get($data, 'Invoices.0.Type') === 'ACCPAY') {
                return new Bill((array) data_get($data, 'Invoices.0'));
            }

            return new Invoice((array) data_get($data, 'Invoices.0'));
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
