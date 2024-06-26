<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;

use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Contact\ContactCollection;

class GetContacts extends Action implements ShouldCheckConnection
{
    /**
     * @return \Supplycart\Xero\Data\Contact\ContactCollection
     */
    public function handle(array $params = [])
    {
        try {
            $whereParam = urldecode(http_build_query($params, '=', ' AND '));

            $response = $this->xero->client->get('https://api.xero.com/api.xro/2.0/Contacts', [
                'query' => [
                    'SummarizeErrors' => 'false',
                    'Where' => $whereParam,
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                    'Xero-tenant-id' => $this->xero->storage->getTenantID(),
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());

            return new ContactCollection(data_get($data, 'Contacts', []));
        } catch (ClientException | Exception $ex) {
            $this->logError(self::class . ': ' . $ex->getMessage());
            throw $ex;
        }
    }
}
