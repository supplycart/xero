<?php

namespace Supplycart\Xero\Actions;

class Disconnect extends Action
{
    public function handle()
    {
        $connections = $this->xero->getConnections();
        $connectionId = data_get($connections, 'collection.0.id');
        $this->xero->client->delete(
            "https://api.xero.com/connections/{$connectionId}",
            [
                'query' => [
                    'SummarizeErrors' => 'false',
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                ],
            ]
        );

        $this->xero->storage->setAccessToken(null);
        $this->xero->storage->setRefreshToken(null);
        $this->xero->storage->persist();
    }
}
