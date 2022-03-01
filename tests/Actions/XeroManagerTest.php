<?php

namespace Supplycart\Xero\Tests\Actions;

use Supplycart\Xero\Actions\GetToken;
use Supplycart\Xero\Tests\TestCase;
use Supplycart\Xero\Xero;
use Supplycart\Xero\XeroManager;

class XeroManagerTest extends TestCase
{
    public function test_can_call_actions()
    {
        $storage = $this->mock(Xero::class);
        $getTokenAction = $this->mock(GetToken::class);

        $getTokenAction
            ->shouldReceive('handle')
            ->verify();

        XeroManager::init($storage)->getToken('test');
    }
}
