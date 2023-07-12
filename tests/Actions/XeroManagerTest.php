<?php

namespace Supplycart\Xero\Tests\Actions;

use Supplycart\Xero\Xero;
use Supplycart\Xero\XeroManager;
use Supplycart\Xero\Tests\TestCase;
use Supplycart\Xero\Actions\GetToken;
use GuzzleHttp\Exception\ClientException;

class XeroManagerTest extends TestCase
{
    public function test_can_call_actions()
    {
        $this->expectException(ClientException::class);

        $storage = $this->mock(Xero::class);
        $getTokenAction = $this->mock(GetToken::class);

        $getTokenAction
            ->shouldReceive('handle')
            ->verify();

        // Invalid code with always return ClientException
        XeroManager::init($storage)->getToken('test');
    }
}
