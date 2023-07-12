<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Spatie\DataTransferObject\DataTransferObjectError;
use Supplycart\Xero\Contracts\ShouldCheckConnection;

class GetOrganisation extends Action implements ShouldCheckConnection
{
    public function handle()
    {
        try {
            $response = $this->xero->client->get('https://api.xero.com/api.xro/2.0/Organisation', [
                'query' => [
                    'SummarizeErrors' => 'false',
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                    'xero-tenant-id' => $this->xero->storage->getTenantID(),
                ],
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (ClientException | DataTransferObjectError | Exception $ex) {
            $this->logError(__CLASS__ . ': ' . $ex->getMessage());
            throw $ex;
        }
    }
}
