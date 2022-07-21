<?php

namespace Supplycart\Xero\Http\Controllers;

use Illuminate\Http\Request;
use Supplycart\Xero\Xero;
use Supplycart\Xero\XeroManager;

class AccountController extends Controller
{
    public function index(Request $request, $uuid)
    {
        $xero = config('xero.xero_model')::findByUuid($uuid);

        $accounts = $xero->manager()->getAccounts();

        return response()->json(data_get($accounts, 'Accounts'));
    }
}
