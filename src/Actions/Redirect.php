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

        if (empty($token)) {
            return $this->failed();
        }

        $storage = $this->xero->storage;

        $storage
            ->setAccessToken($token->accessToken)
            ->setRefreshToken($token->refreshToken)
            ->setExpiredAt(Carbon::now()->addSeconds($token->expiresIn))
            ->persist();

        $connections = $this->xero->getConnections();

        if (empty($connections)) {
            return $this->failed();
        }

        $storage->setTenantID(data_get($connections, '0.tenantId'));
        $storage->persist();

        XeroAuthenticated::dispatch($storage->getUuid(), $token);

        return redirect()->away(config('xero.authenticated_uri'));
    }

    public function failed()
    {
        XeroAuthenticationFailed::dispatch($this->xero->storage->getUuid());

        return response()->json(['status' => 'error', 'message' => 'Unable to authenticate with XERO']);
    }
}
