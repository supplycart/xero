<?php

namespace Supplycart\Xero\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Supplycart\Xero\Xero;
use Supplycart\Xero\XeroManager;

class StatusController extends Controller
{
    public function show($uuid)
    {
        $xero = Xero::findByUuid($uuid);

        return response()->json([
            'is_authenticated' => $xero->manager()->isAuthenticated(),
            'is_connected' => $xero->manager()->isConnected(),
            'status' => $xero->refresh()->toArray(),
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $xero = Xero::findByUuid(['uuid' => $uuid]);

        $xero->update($request->only('contact_id', 'is_enabled', 'account_code'));

        if (!$request->is_enabled) {
            $xero->manager()->disconnect();

            return response()->json([
                'is_authenticated' => true,
                'is_connected' => false,
                'status' => $xero->refresh()->toArray(),
            ]);
        }

        return response()->json([
            'is_authenticated' => $xero->manager()->isAuthenticated(),
            'is_connected' => $xero->manager()->isConnected(),
            'status' => $xero->refresh()->toArray(),
        ]);
    }
}
