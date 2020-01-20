<?php

namespace Supplycart\Xero\Actions;

use GuzzleHttp\Exception\ClientException;
use Supplycart\Xero\Data\Connection\ConnectionCollection;

class GetConnections extends Action
{
    public function handle()
    {
        $this->log(__CLASS__ . ': START');

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
        } catch (ClientException $e) {
            $this->log('ERROR!: ' . $e->getMessage());

            return [];
        }

        $connections = (array) json_decode($response->getBody()->getContents());

        $this->log(__CLASS__ . ': ENDS');

        return new ConnectionCollection($connections);
    }
}
