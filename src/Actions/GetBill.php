<?php

namespace Supplycart\Xero\Actions;

use Exception as Exception;
use Spatie\DataTransferObject\DataTransferObjectError;
use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Invoice\Bill;

class GetBill extends Action implements ShouldCheckConnection
{
    /**
     * @param string $invoiceId
     */
    public function handle(string $invoiceId, bool $asPdf = false)
    {
        try {
            $response = $this->xero->client->get(
                "https://api.xero.com/api.xro/2.0/Invoices/{$invoiceId}",
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                        'xero-tenant-id' => $this->xero->storage->getTenantID(),
                        'Accept' => $asPdf ? 'application/pdf' : 'application/json'
                    ],
                ]
            );

            
            if ($asPdf) {
                return $response->getBody();
            } else {
                $data = (array) json_decode($response->getBody()->getContents());
                return data_get($data, 'Invoices.0') ? new Bill((array) data_get($data, 'Invoices.0')) : null;
            }
        } catch (DataTransferObjectError $ex) {
            throw new Exception(sprintf('%s: Line: %s, Error: %s', get_class($ex), $ex->getLine(), $ex->getMessage()));
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}