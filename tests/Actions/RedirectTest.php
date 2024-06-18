<?php

namespace Supplycart\Xero\Tests\Actions;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Supplycart\Xero\Actions\Redirect;
use Supplycart\Xero\Contracts\Storage;
use Supplycart\Xero\Data\Connection\ConnectionCollection;
use Supplycart\Xero\Data\Token;
use Supplycart\Xero\Tests\TestCase;
use Supplycart\Xero\XeroManager;

class RedirectTest extends TestCase
{
    #[\Override]
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->config->set('xero.oauth2.authenticated_uri', 'https://www.supplycart.my');
    }

    public function test_can_redirect_after_received_token()
    {
        $storage = $this->mock(Storage::class);
        $manager = $this->mock(XeroManager::class);

        $manager
            ->shouldReceive('getToken')
            ->andReturn(new Token((array) json_decode(File::get(__DIR__ . '/../stubs/xero/access-token.json'))))
            ->andSet('storage', $storage);

        $storage
            ->shouldReceive('setAccessToken')
            ->andReturnSelf();

        $storage
            ->shouldReceive('setRefreshToken')
            ->andReturnSelf();

        $storage
            ->shouldReceive('setExpiredAt')
            ->andReturnSelf();

        $storage->shouldReceive('persist');

        $manager
            ->shouldReceive('getConnections')
            ->andReturn(new ConnectionCollection((array) json_decode(File::get(__DIR__ . '/../stubs/xero/connections.json'))));

        $storage
            ->shouldReceive('getUuid')
            ->andReturn(Str::uuid());

        $storage
            ->shouldReceive('setTenantId')
            ->andReturnSelf();

        $storage
            ->shouldReceive('setTenantName')
            ->andReturnSelf();

        $redirect = $this->mock(Redirector::class);

        $redirect
            ->shouldReceive('away');

        $response = (new Redirect($manager))->handle('test');

        $this->assertTrue($response->isRedirect('https://www.supplycart.my'));
    }
}
