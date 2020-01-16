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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function handle(Request $request)
    {
        $token = $this->xero->getToken($request->input('code'));

        $storage = $this->xero->storage;

        $storage
            ->setAccessToken($token->access_token)
            ->setRefreshToken($token->refresh_token)
            ->setExpiredAt(Carbon::now()->addSeconds($token->expires_in))
            ->persist();

        $connections = $this->xero->getConnections();

        if (empty($connections)) {
            XeroAuthenticationFailed::dispatch($storage->getUuid());

            return response()->json(['status' => 'error', 'message' => 'Unable to authenticate with XERO']);
        }

        $storage->setTenantID(data_get($connections, '0.tenantId'));
        $storage->persist();

        XeroAuthenticated::dispatch($storage->getUuid(), $token);

        return redirect()->away(config('xero.authenticated_uri'));
    }
}
