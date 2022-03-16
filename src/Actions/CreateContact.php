<?php

namespace Supplycart\Xero\Actions;

use Exception;
use Supplycart\Xero\Data\Contact\Contact;

class CreateContact extends Action
{
    public function handle(array $data)
    {
        try {
            $this->log(__CLASS__ . ': START');

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

            $this->log(__CLASS__ . ': END');

            return (array) data_get($data, 'Contacts.0');
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
