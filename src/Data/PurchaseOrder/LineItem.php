<?php

namespace Supplycart\Xero\Data\PurchaseOrder;

use Supplycart\Xero\Data\Data;

class LineItem extends Data
{
    public bool $ignoreMissing = true;

    public $LineItemID;

    public $Description;

    public $Quantity;

    public $UnitAmount;

    public $ItemCode;

    public $AccountCode;

    public $TaxType;

    public $DiscountRate;

    public $Tracking;

    public $TaxAmount;

    public $LineAmount;
}
