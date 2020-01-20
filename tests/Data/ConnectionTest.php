<?php

namespace Supplycart\Xero\Tests\Data;

use Illuminate\Support\Facades\File;
use Supplycart\Xero\Data\Connection\Connection;
use Supplycart\Xero\Data\Connection\ConnectionCollection;
use Supplycart\Xero\Data\Token;
use Supplycart\Xero\Tests\TestCase;

class ConnectionTest extends TestCase
{
    public function test_can_transfer_connection_data()
    {
        $data = (array) json_decode(File::get(__DIR__ . '/../stubs/xero/connections.json'));

        $connections = new ConnectionCollection($data);
        $this->assertEquals(2, $connections->count());

        $connection = $connections[0];
        $this->assertEquals('e82447cc-ce78-468f-b2c6-9af74c519ead', $connection->id);
        $this->assertEquals('83299b9e-5747-4a14-a18a-a6c94f824eb7', $connection->tenantId);
        $this->assertEquals('ORGANISATION', $connection->tenantType);
    }
}