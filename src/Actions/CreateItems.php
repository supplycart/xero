<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\DataTransferObject\DataTransferObjectError;
use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Item\Item;

class CreateItems extends Action implements ShouldCheckConnection
{
    use Dispatchable;

    /**
     * @var array
     */
    private $data;

    public function handle(array $data)
    {
        try {
            $response = $this->xero->client->put(
                'https://api.xero.com/api.xro/2.0/Items',
                [
                    'query' => [
                        'SummarizeErrors' => 'false',
                    ],
                    'json' => [
                        'Items' => $data,
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                        'xero-tenant-id' => $this->xero->storage->getTenantID(),
                    ],
                ]
            );

            $data = (array) json_decode($response->getBody()->getContents());

            $items = [];
            foreach (data_get($data, 'Items', []) as $itemData) {
                $items[] = new Item((array) $itemData);
            }
            return $items;
        } catch (ClientException | DataTransferObjectError | Exception $ex) {
            $this->logError(__CLASS__ . ': ' . $ex->getMessage());
            throw $ex;
        }
    }
}
