<?php

namespace Supplycart\Xero\Actions;

use Exception;

class GetManualJournals extends Action
{
    public function handle(
        string $manualJournalID = '',
        string $ifModifiedSince = '',
        array $whereFilter = [],
        string $order = '',
        int $page = 1
    ) {
        try {
            $baseUrl = 'https://api.xero.com/api.xro/2.0/ManualJournals';
            $where = urldecode(http_build_query(array_map(fn ($value) => '"' . $value . '"', $whereFilter), '=', ' AND '));

            $response = $this->xero->client->get(
                $manualJournalID ?
                $baseUrl .= '/' . $manualJournalID :
                $baseUrl,
                [
                    'query' => [
                        'SummarizeErrors' => 'false',
                        'where' => $where,
                        'page' => $page,
                        'order' => $order,
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                        'xero-tenant-id' => $this->xero->storage->getTenantID(),
                        'If-Modified-Since' => $ifModifiedSince,
                    ],
                ]
            );

            $data = (array) json_decode($response->getBody()->getContents());
            return (array) data_get($data, 'ManualJournals');
        } catch (Exception $ex) {
            $this->log($ex->getResponse()->getBody()->getContents(), 'error');
            throw $ex;
        }
    }
}
