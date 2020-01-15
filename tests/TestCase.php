<?php


use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Supplycart\Xero\XeroServiceProvider::class,
        ];
    }

}