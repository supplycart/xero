<?php

namespace Supplycart\Xero\Http\Controllers;

use Illuminate\Http\Request;
use Supplycart\Xero\Xero;

class ContactController extends Controller
{
    public function index(Request $request, $uuid)
    {
        /** @var Xero $xero */
        $xero = Xero::findByUuid($uuid);

        $contacts = $xero->manager()->getContacts();

        return response()->json($contacts);
    }
}
