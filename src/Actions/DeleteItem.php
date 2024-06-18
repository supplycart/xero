<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Bus\Dispatchable;

use Supplycart\Xero\Contracts\ShouldCheckConnection;

class DeleteItem extends Action implements ShouldCheckConnection
{
    use Dispatchable;

    public function handle(string $itemId)
    {
        try {
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
        } catch (ClientException | Exception $ex) {
            $this->logError(self::class . ': ' . $ex->getMessage());
            throw $ex;
        }
    }
}
