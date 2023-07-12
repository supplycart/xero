<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Spatie\DataTransferObject\DataTransferObjectError;
use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\History\History;

class CreateHistory extends Action implements ShouldCheckConnection
{
    /**
     * @param string $endpoint
     * @param string $guid
     * @param array $notes
     *
     * @return \Supplycart\Xero\Data\History\History
     */
    public function handle(string $endpoint, string $guid, array $notes = [])
    {
        try {
            $url = sprintf('https://api.xero.com/api.xro/2.0/%s/%s/History', $endpoint, $guid);

            $data = [
                'HistoryRecords' => array_map(function ($note) {
                    return [
                        'Details' => $note,
                    ];
                }, $notes),
            ];

            $response = $this->xero->client->put(
                $url,
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

            return new History((array) data_get($data, 'HistoryRecords.0'));
        } catch (ClientException | DataTransferObjectError | Exception $ex) {
            $this->logError(__CLASS__ . ': ' . $ex->getMessage());
            throw $ex;
        }
    }
}
