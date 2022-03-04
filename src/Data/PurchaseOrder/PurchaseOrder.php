<?php

namespace Supplycart\Xero\Data\PurchaseOrder;

use Supplycart\Xero\Data\Data;

/**
 * Class PurchaseOrder
 * @package Supplycart\Xero\Data
 */
class PurchaseOrder extends Data
{
    public bool $ignoreMissing = true;

    public $PurchaseOrderID;

    /**
     * @var \Supplycart\Xero\Data\Contact|array|object|null
     */
    public $Contact;

    public $Date;

    public $DeliveryDate;

    public $LineAmountTypes;

    public $PurchaseOrderNumber;

    public $Reference;

    /**
     * @var \Supplycart\Xero\Data\PurchaseOrder\LineItemCollection|array|object|null
     */
    public $LineItems;

    public $BrandingThemeID;

    public $CurrencyCode;

    public $Status;

    public $SentToContact;

    public $DeliveryAddress;

    public $AttentionTo;

    public $Telephone;

    public $DeliveryInstructions;

    public $ExpectedArrivalDate;

    public $CurrencyRate;

    public $SubTotal;

    public $TotalTax;

    public $Total;

    public $TotalDiscount;

    public $HasAttachments;

    public $UpdatedDateUTC;

    public $HasErrors;

    public $ValidationErrors;
}
