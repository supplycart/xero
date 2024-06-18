<?php

namespace Supplycart\Xero\Actions;

use Exception;
use GuzzleHttp\Exception\ClientException;

use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Data\Attachment\Attachment;

class CreateAttachment extends Action implements ShouldCheckConnection
{
    /**
     * @param $content
     */
    public function handle(string $endpoint, string $guid, string $filename, string $contentType, $content)
    {
        try {
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

            return new Attachment((array) data_get($data, 'Attachments.0'));
        } catch (ClientException | Exception $ex) {
            $this->logError(self::class . ': ' . $ex->getMessage());
            throw $ex;
        }
    }
}
