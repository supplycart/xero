<?php

namespace Supplycart\Xero\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Supplycart\Xero\Data\TokenResponse;
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
        $data = (array) $this->xero->getToken($request->input('code'));

        $storage = $this->xero->storage;

        $storage
            ->setAccessToken($accessToken = data_get($data, 'access_token'))
            ->setRefreshToken($refreshToken = data_get($data, 'refresh_token'))
            ->setExpiredAt(Carbon::now()->addSeconds(data_get($data, 'expires_in')))
            ->persist();

        $connections = $this->xero->getConnections();

        if (empty($connections)) {
            XeroAuthenticationFailed::dispatch();

            return response()->json(['status' => 'error', 'message' => 'Unable to authenticate with XERO']);
        }

        $storage->setTenantID(data_get($connections, '0.tenantId'));
        $storage->persist();

        XeroAuthenticated::dispatch(new TokenResponse($data), $storage->getUuid());

        return redirect()->away(config('xero.authenticated_uri'));
    }
}
