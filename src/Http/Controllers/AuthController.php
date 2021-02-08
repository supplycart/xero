<?php

namespace Supplycart\Xero\Http\Controllers;

use Illuminate\Http\Request;
use Supplycart\Xero\Xero;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        /** @var Xero $xero */
        $xero = Xero::findByUuid($request->input('state'));

        return $xero->manager()->authenticate($request);
    }

    public function redirect(Request $request)
    {
        /** @var Xero $xero */
        $xero = Xero::findByUuid($request->input('state'));

        return $xero->manager()->redirect($request->input('code'));
    }

    public function authenticateInternal(Request $request) 
    {
        /** @var Xero $xero */
        $xero = Xero::findByUuid($request->input('state'));

        return $xero->manager()->authenticateInternal($request);
    }

    public function redirectInternal(Request $request)
    {
        /** @var Xero $xero */
        $xero = Xero::findByUuid($request->input('state'));

        return $xero->manager()->redirectInternal($request->input('code'));
    }
}
