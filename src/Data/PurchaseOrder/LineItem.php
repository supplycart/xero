<?php

namespace Supplycart\Xero\Data\PurchaseOrder;

use Supplycart\Xero\Data\Data;

class LineItem extends Data
{
    public $LineItemID;

    public $Description;

    public $Quantity;

    public $UnitAmount;

    public $ItemCode;

    public $AccountCode;

    public $TaxType;

    public $TaxAmount;

    public $LineAmount;

    public $DiscountRate;
}
