<?php

namespace Supplycart\Xero\Actions;

class Disconnect extends Action
{
    public function handle()
    {
        $this->log(__CLASS__ . ': START');

        $connections = $this->xero->getConnections();
        $connectionId = data_get($connections, '0.id');

        $this->xero->client->delete("https://api.xero.com/connections/{$connectionId}");

        $this->xero->storage->setAccessToken(null);
        $this->xero->storage->setRefreshToken(null);
        $this->xero->storage->persist();

        $this->log(__CLASS__ . ': ENDS');
    }
}
