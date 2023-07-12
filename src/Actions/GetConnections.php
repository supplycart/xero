<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Spatie\DataTransferObject\DataTransferObjectError;
use Supplycart\Xero\Data\Connection\ConnectionCollection;

class GetConnections extends Action
{
    public function handle()
    {
        try {
            $response = $this->xero->client->get(
                'https://api.xero.com/connections',
                [
                    'query' => [
                        'SummarizeErrors' => 'false',
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                    ],
                ]
            );

            $connections = (array) json_decode($response->getBody()->getContents());

            return new ConnectionCollection($connections);
        } catch (ClientException | DataTransferObjectError | Exception $ex) {
            $this->logError(__CLASS__ . ': ' . $ex->getMessage());
            throw $ex;
        }
    }
}
