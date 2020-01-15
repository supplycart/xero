<?php

namespace Supplycart\Xero\Actions;

use GuzzleHttp\Exception\ClientException;

class GetConnections extends Action
{
    public function handle()
    {
        logs()->info(__CLASS__ . ': START');

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
            logs()->info('ERROR!: ' . $e->getMessage());

            return [];
        }

        $connections = json_decode($response->getBody()->getContents());

        logs()->info(__CLASS__ . ': ENDS');

        return $connections;
    }
}
