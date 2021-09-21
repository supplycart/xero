<?php

namespace Supplycart\Xero\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Supplycart\Xero\Data\Token;
use Supplycart\Xero\Events\XeroAuthenticated;
use Supplycart\Xero\Events\XeroAuthenticationFailed;

class Redirect extends Action
{
    /**
     * @param string $code
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function handle(string $code = null)
    {
        if (is_null($code)) {
            return redirect()->away(config('xero.oauth2.authenticated_uri'));
        }
        
        $token = $this->xero->getToken($code);

        if (empty($token)) {
            return $this->failed();
        }

        $storage = $this->xero->storage;

        $storage
            ->setAccessToken($token->access_token)
            ->setRefreshToken($token->refresh_token)
            ->setExpiredAt(Carbon::now()->addSeconds($token->expires_in))
            ->persist();

        $connections = $this->xero->getConnections();

        if (empty($connections)) {
            return $this->failed();
        }

        $storage->setTenantID($connections[0]->tenantId);
        $storage->setTenantName($connections[0]->tenantName);
        $storage->persist();

        XeroAuthenticated::dispatch($storage->getUuid(), $token);

        return redirect()->away(config('xero.oauth2.authenticated_uri'));
    }

    public function failed()
    {
        XeroAuthenticationFailed::dispatch($this->xero->storage->getUuid());

        return response()->json(['status' => 'error', 'message' => 'Unable to authenticate with XERO']);
    }
}
