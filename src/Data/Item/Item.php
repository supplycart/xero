<?php

namespace Supplycart\Xero\Data\Item;

use Spatie\DataTransferObject\DataTransferObject;

class Item extends DataTransferObject
{
    public $ItemID;

    public $Code;

    public $Name;

    public $IsSold;

    public $IsPurchased;

    public $Description;

    public $PurchaseDescription;

    public $PurchaseDetails;

    public $SalesDetails;

    public $IsTrackedAsInventory;

    public $InventoryAssetAccountCode;

    public $TotalCostPool;

    public $QuantityOnHand;

    public $UpdatedDateUTC;

    public $ValidationErrors;

    public $StatusAttributeString;
}
