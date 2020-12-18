<?php

namespace Supplycart\Xero\Actions;

use Illuminate\Foundation\Bus\Dispatchable;
use Supplycart\Xero\Contracts\ShouldCheckConnection;

class DeleteItem extends Action implements ShouldCheckConnection
{
    use Dispatchable;

    public function handle(string $itemId)
    {
        $response = $this->xero->client->delete("https://api.xero.com/api.xro/2.0/Items/{$itemId}", [
            'query' => [
                'SummarizeErrors' => 'false',
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                'Xero-tenant-id' => $this->xero->storage->getTenantID(),
            ],
        ]);

        return response()->json(['status' => 'success', 'message' => 'Item deleted']);
    }
}
