<?php

namespace Supplycart\Xero\Http\Controllers;

use Supplycart\Xero\Xero;

class TaxRateController extends Controller
{
    public function index($uuid)
    {
        $xero = config('xero.xero_model')::findByUuid($uuid);

        $rates = $xero->manager()->getTaxRates();

        return response()->json($rates);
    }
}
