<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;

use Supplycart\Xero\Data\ManualJournal\Journal;

class CreateManualJournal extends Action
{
    public function handle(Journal $journal)
    {
        try {
            $response = $this->xero->client->post(
                'https://api.xero.com/api.xro/2.0/ManualJournals',
                [
                    'query' => [
                        'SummarizeErrors' => 'false',
                    ],
                    'json' => $journal,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                        'xero-tenant-id' => $this->xero->storage->getTenantID(),
                    ],
                ]
            );

            $data = (array) json_decode($response->getBody()->getContents());
            $journalData = data_get($data, 'ManualJournals.0');
            return new Journal(json_decode(json_encode($journalData), true));
        } catch (ClientException | Exception $ex) {
            $this->logError(self::class . ': ' . $ex->getMessage());
            throw $ex;
        }
    }
}
