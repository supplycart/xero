<?php

namespace Supplycart\Xero\Actions;

use Exception as Exception;
use Spatie\DataTransferObject\DataTransferObjectError;
use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Invoice\BillCollection;

class GetBills extends Action implements ShouldCheckConnection
{
    /**
     * @param array $where
     * @param array $contactIds
     * @param array $invoiceNumbers
     *
     * @return \Supplycart\Xero\Data\Invoice\BillCollection
     */
    public function handle(array $where = [], array $contactIds = [], array $invoiceNumbers = [])
    {
        try {
            $whereParam = urldecode(http_build_query($where, '==', ' AND '));
            $contactIds = implode(',', $contactIds);
            $invoiceNumbers = implode(',', $invoiceNumbers);

            $response = $this->xero->client->get(
                "https://api.xero.com/api.xro/2.0/Invoices",
                [
                    'query' => [
                        'SummarizeErrors' => 'false',
                        'where' => $whereParam,
                        'ContactIDs' => $contactIds,
                        'InvoiceNumbers' => $invoiceNumbers,
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                        'xero-tenant-id' => $this->xero->storage->getTenantID(),
                    ],
                ]
            );

            $data = (array) json_decode($response->getBody()->getContents());

            return new BillCollection((array) data_get($data, 'Invoices'));
        } catch (DataTransferObjectError $ex) {
            throw new Exception(sprintf('%s: Line: %s, Error: %s', get_class($ex), $ex->getLine(), $ex->getMessage()));
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
