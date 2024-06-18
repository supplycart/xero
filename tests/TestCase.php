<?php

namespace Supplycart\Xero\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    #[\Override]
    protected function getPackageProviders($app)
    {
        return [
            \Supplycart\Xero\XeroServiceProvider::class,
        ];
    }
}
