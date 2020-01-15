<?php

namespace Supplycart\Xero\Http\Controllers;

use Illuminate\Http\Request;
use Supplycart\Xero\Xero;
use Supplycart\Xero\XeroManager;

class OrganisationController extends Controller
{
    public function index(Request $request, $uuid)
    {
        $organisation = Xero::findByUuid($uuid)->manager()->getOrganisation();

        return response()->json(data_get($organisation, 'Organisations.0'));
    }
}
