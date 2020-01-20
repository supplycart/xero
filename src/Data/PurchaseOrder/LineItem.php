<?php

namespace Supplycart\Xero\Data;

class LineItem extends Data
{
    /**
     * @var string
     */
    public $LineItemID;

    /**
     * @var string
     */
    public $Description;

    /**
     * @var int
     */
    public $Quantity;

    /**
     * @var float
     */
    public $UnitAmount;

    /**
     * @var float
     */
    public $TaxAmount;

    /**
     * @var float
     */
    public $LineAmount;

    /**
     * @var string
     */
    public $ItemCode;

    /**
     * @var string
     */
    public $AccountCode;

    /**
     * @var string
     */
    public $TaxType;
}
