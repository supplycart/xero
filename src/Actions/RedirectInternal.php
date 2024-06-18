<?php

namespace Supplycart\Xero\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Supplycart\Xero\Data\Token;
use Supplycart\Xero\Events\XeroAuthenticated;
use Supplycart\Xero\Events\XeroAuthenticationFailed;
use Supplycart\Xero\Xero;

class RedirectInternal extends Action
{
    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function handle(string $code)
    {
        $token = $this->xero->getTokenInternal($code);

        if (empty($token)) {
            return $this->failed();
        }

        //create temporary xero to hold tokens
        $xeroTemp = config('xero.xero_model')::create(['uuid' => Str::uuid()]);
        $storageTemp = $xeroTemp->manager()->storage;

        $storageTemp
            ->setAccessToken($token->access_token)
            ->setRefreshToken($token->refresh_token)
            ->setExpiredAt(Carbon::now()->addSeconds($token->expires_in))
            ->persist();

        $connections = $xeroTemp->manager()->getConnections();

        if (empty($connections)) {
            return $this->failed();
        }

        $connectionsArray = $connections->toArray();

        foreach ($connectionsArray as $connection) {
            $this->log($connection['tenantId']);
            $xero = config('xero.xero_model')::where('tenant_id', $connection['tenantId'])->where('is_internal', true)->first();
            if (!$xero) {
                $xero = config('xero.xero_model')::create([
                    'uuid' => Str::uuid(),
                    'is_internal' => true,
                    'tenant_id' => $connection['tenantId']
                ]);
            }

            $storage = $xero->manager()->storage;

            $storage
                ->setAccessToken($token->access_token)
                ->setRefreshToken($token->refresh_token)
                ->setExpiredAt(Carbon::now()->addSeconds($token->expires_in))
                ->persist();

            $organisation = $xero->manager()->getOrganisation();

            $storage
                ->setTenantName(json_decode(json_encode($organisation), true)['Organisations'][0]['Name'])
                ->persist();

            XeroAuthenticated::dispatch($storage->getUuid(), $token);
        }

        //Delete the temp xero
        $xeroTemp->delete();

        return redirect()->away(config('xero.oauth2_internal.authenticated_uri'));
    }

    public function failed()
    {
        XeroAuthenticationFailed::dispatch($this->xero->storage->getUuid());

        return response()->json(['status' => 'error', 'message' => 'Unable to authenticate with XERO']);
    }
}
