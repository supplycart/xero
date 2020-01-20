<?php

namespace Supplycart\Xero\Data\PurchaseOrder;

use Spatie\DataTransferObject\DataTransferObjectCollection;
use Supplycart\Xero\Data\LineItem;

class LineItemCollection extends DataTransferObjectCollection
{
    public function current(): LineItem
    {
        return parent::current();
    }
}