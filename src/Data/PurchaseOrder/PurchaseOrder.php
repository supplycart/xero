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
    /**
     * @var string
     */
    public $PurchaseOrderID;

    /**
     * @var string
     */
    public $PurchaseOrderNumber;

    /**
     * @var string
     */
    public $Reference;

    /**
     * @var string
     */
    public $AttentionTo;

    /**
     * @var string
     */
    public $Telephone;

    /**
     * @var string
     */
    public $DeliveryAddress;

    /**
     * @var string
     */
    public $DeliveryDateString;

    /**
     * @var string
     */
    public $DeliveryInstructions;

    /**
     * @var string
     */
    public $DateString;

    /**
     * @var string
     */
    public $Status;

    /**
     * @var string
     */
    public $SubTotal;

    /**
     * @var string
     */
    public $TotalTax;

    /**
     * @var string
     */
    public $Total;

    /**
     * @var \Supplycart\Xero\Data\PurchaseOrder\LineItemCollection
     */
    public $LineItems;

    /**
     * @var \Supplycart\Xero\Data\Contact
     */
    public $Contact;
}
