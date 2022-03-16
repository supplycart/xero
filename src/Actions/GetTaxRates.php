<?php

namespace Supplycart\Xero\Actions;

use Exception;
use Spatie\DataTransferObject\DataTransferObjectError;
use Supplycart\Xero\Data\TaxRate\TaxRateCollection;
use Supplycart\Xero\Contracts\ShouldCheckConnection;

class GetTaxRates extends Action implements ShouldCheckConnection
{
    /**
     * @param array $where
     *
     * @return \Supplycart\Xero\Data\TaxRate\TaxRateCollection
     */
    public function handle(array $where = [])
    {
        try {
            $whereParam = urldecode(http_build_query($where, '==', ' AND '));

            $response = $this->xero->client->get('https://api.xero.com/api.xro/2.0/TaxRates', [
                'query' => [
                    'SummarizeErrors' => 'false',
                    'where' => $whereParam,
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                    'xero-tenant-id' => $this->xero->storage->getTenantID(),
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());

            return new TaxRateCollection((array) data_get($data, 'TaxRates'));
        } catch (DataTransferObjectError $ex) {
            throw new Exception(sprintf('%s: Line: %s, Error: %s', get_class($ex), $ex->getLine(), $ex->getMessage()));
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
