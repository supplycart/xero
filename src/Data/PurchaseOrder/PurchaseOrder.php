<?php

namespace Supplycart\Xero\Data\PurchaseOrder;

use Spatie\DataTransferObject\DataTransferObject;
use Supplycart\Xero\Data\Data;
use Supplycart\Xero\Exceptions\InvalidAttributesException;

/**
 * Class PurchaseOrder
 * @package Supplycart\Xero\Data
 */
class PurchaseOrder extends Data
{
    public $PurchaseOrderID;

    public $PurchaseOrderNumber;

    public $Reference;

    public $AttentionTo;

    public $Telephone;

    public $DeliveryAddress;

    public $DeliveryDateString;

    public $DeliveryInstructions;

    public $DateString;

    public $Status;

    public $SubTotal;

    public $TotalTax;

    public $Total;

    public $Date;

    public $HasErrors;

    public $IsDiscounted;

    public $TotalDiscount;

    public $SentToContact;

    public $Type;

    public $CurrencyRate;

    public $CurrencyCode;

    public $LineAmountTypes;

    public $UpdatedDateUTC;

    public $LineItems;

    public $StatusAttributeString;

    public $HasAttachments;

    public $Attachments;

    public $Contact;
}
