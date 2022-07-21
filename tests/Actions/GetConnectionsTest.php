<?php

namespace Supplycart\Xero\Tests\Actions;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Supplycart\Xero\Actions\GetConnections;
use Supplycart\Xero\Actions\GetToken;
use Supplycart\Xero\Contracts\Storage;
use Supplycart\Xero\Data\Connection\Connection;
use Supplycart\Xero\Data\Connection\ConnectionCollection;
use Supplycart\Xero\Data\Token;
use Supplycart\Xero\Tests\TestCase;
use Supplycart\Xero\Xero;
use Supplycart\Xero\XeroManager;

class GetConnectionsTest extends TestCase
{
    public function test_can_get_connections()
    {
        $storage = $this->mock(Storage::class);
        $client = $this->mock(Client::class);
        $response = $this->mock(ResponseInterface::class);
        $stream = $this->mock(StreamInterface::class);

        $storage
            ->shouldReceive('getAccessToken')
            ->andReturn('test');

        $client
            ->shouldReceive('get')
            ->andReturn($response);

        $response
            ->shouldReceive('getBody')
            ->andReturn($stream);

        $stream
            ->shouldReceive('getContents')
            ->andReturn(File::get(__DIR__ . '/../stubs/xero/connections.json'));

        $action = new GetConnections(new XeroManager($client, $storage));
        $connections = $action->handle();

        $this->assertInstanceOf(ConnectionCollection::class, $connections);
        $this->assertInstanceOf(Connection::class, $connection = $connections->collection[0]);
    }
}
