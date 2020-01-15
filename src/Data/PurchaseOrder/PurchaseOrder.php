<?php

namespace Supplycart\Xero\Data\PurchaseOrder;

use Supplycart\Xero\Data\Data;
use Supplycart\Xero\Exceptions\InvalidAttributesException;

/**
 * Class PurchaseOrder
 * @package Supplycart\Xero\Data
 *
 * @property string PurchaseOrderID
 * @property string PurchaseOrderNumber
 * @property string Reference
 * @property string AttentionTo
 * @property string Telephone
 * @property string DeliveryAddress
 * @property string DeliveryDateString
 * @property string DeliveryInstructions
 * @property string DateString
 * @property string Status
 * @property array LineItems
 * @property float SubTotal
 * @property float TotalTax
 * @property float Total
 * @property \Supplycart\Xero\Data\Contact Contact
 */
class PurchaseOrder extends Data
{
    public function rules()
    {
        return [
            'Contact' => ['required'],
            'LineItems' => ['required'],
        ];
    }

}
