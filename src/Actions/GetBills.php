<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;

use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Invoice\BillCollection;

class GetBills extends Action implements ShouldCheckConnection
{
    /**
     *
     * @return \Supplycart\Xero\Data\Invoice\BillCollection
     */
    public function handle(array $where = [], array $contactIds = [], array $invoiceNumbers = [], array $invoiceIds = [])
    {
        try {
            $whereParam = urldecode(http_build_query($where, '==', ' AND '));
            $contactIds = implode(',', $contactIds);
            $invoiceNumbers = implode(',', $invoiceNumbers);
            $invoiceIds = implode(',', $invoiceIds);

            $response = $this->xero->client->get(
                "https://api.xero.com/api.xro/2.0/Invoices",
                [
                    'query' => [
                        'SummarizeErrors' => 'false',
                        'where' => $whereParam,
                        'ContactIDs' => $contactIds,
                        'InvoiceNumbers' => $invoiceNumbers,
                        'IDs' => $invoiceIds,
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                        'xero-tenant-id' => $this->xero->storage->getTenantID(),
                    ],
                ]
            );

            $data = (array) json_decode($response->getBody()->getContents());

            return new BillCollection((array) data_get($data, 'Invoices'));
        } catch (ClientException | Exception $ex) {
            $this->logError(self::class . ': ' . $ex->getMessage());
            throw $ex;
        }
    }
}
