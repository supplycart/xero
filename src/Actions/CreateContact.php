<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Spatie\DataTransferObject\DataTransferObjectError;

class CreateContact extends Action
{
    public function handle(array $data)
    {
        try {
            $response = $this->xero->client->post(
                'https://api.xero.com/api.xro/2.0/Contacts',
                [
                    'query' => [
                        'SummarizeErrors' => 'false',
                    ],
                    'json' => $data,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                        'xero-tenant-id' => $this->xero->storage->getTenantID(),
                    ],
                ]
            );

            $data = (array) json_decode($response->getBody()->getContents());

            return (array) data_get($data, 'Contacts.0');
        } catch (ClientException | DataTransferObjectError | Exception $ex) {
            $this->logError(__CLASS__ . ': ' . $ex->getMessage());
            throw $ex;
        }
    }
}
