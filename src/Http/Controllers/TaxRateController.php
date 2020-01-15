<?php

namespace Supplycart\Xero\Http\Controllers;

use Supplycart\Xero\Xero;

class TaxRateController extends Controller
{
    public function index($uuid)
    {
        $xero = Xero::findByUuid($uuid);

        $rates = $xero->manager()->getTaxRates();

        return response()->json($rates);
    }
}
