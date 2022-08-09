<?php

namespace Supplycart\Xero\Actions;

use Exception;
use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Attachment\Attachment;

class CreateAttachment extends Action implements ShouldCheckConnection
{
    /**
     * @param string $endpoint
     * @param string $guid
     * @param string $filename
     * @param $content
     */
    public function handle(string $endpoint, string $guid, string $filename, string $contentType, $content)
    {
        try {
            $this->log(__CLASS__ . ': START');

            $url = sprintf('https://api.xero.com/api.xro/2.0/%s/%s/Attachments/%s', $endpoint, $guid, $filename);

            $response = $this->xero->client->post(
                $url,
                [
                    'query' => [
                        'SummarizeErrors' => 'false',
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->xero->storage->getAccessToken(),
                        'xero-tenant-id' => $this->xero->storage->getTenantID(),
                        'Content-Type' => $contentType,
                    ],
                    'body' => $content,
                ]
            );

            $data = (array) json_decode($response->getBody()->getContents());

            $this->log(__CLASS__ . ': END');

            return new Attachment((array) data_get($data, 'Attachments.0'));

        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
