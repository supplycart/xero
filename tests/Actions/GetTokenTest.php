<?php

namespace Supplycart\Xero\Tests\Actions;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Supplycart\Xero\Actions\GetToken;
use Supplycart\Xero\Contracts\Storage;
use Supplycart\Xero\Data\Token;
use Supplycart\Xero\Tests\TestCase;
use Supplycart\Xero\Xero;
use Supplycart\Xero\XeroManager;

class GetTokenTest extends TestCase
{
    public function test_can_get_access_token()
    {
        $storage = $this->mock(Storage::class);
        $client = $this->mock(Client::class);
        $response = $this->mock(ResponseInterface::class);
        $stream = $this->mock(StreamInterface::class);

        $client
            ->shouldReceive('post')
            ->andReturn($response);

        $response
            ->shouldReceive('getBody')
            ->andReturn($stream);

        $stream
            ->shouldReceive('getContents')
            ->andReturn(File::get(__DIR__ . '/../stubs/xero/access-token.json'));

        $action = new GetToken(new XeroManager($client, $storage));
        $token = $action->handle('test');

        $this->assertNotNull($token);

        $this->assertArrayHasKey('access_token', $token->toArray());
        $this->assertArrayHasKey('id_token', $token->toArray());
        $this->assertArrayHasKey('refresh_token', $token->toArray());
        $this->assertArrayHasKey('token_type', $token->toArray());
        $this->assertArrayHasKey('expires_in', $token->toArray());
    }
}
