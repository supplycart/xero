<?php

namespace Supplycart\Xero\Data\PurchaseOrder;

use Supplycart\Xero\Data\DataCollection;
use Supplycart\Xero\Data\PurchaseOrder\LineItem;

class LineItemCollection extends DataCollection
{
    public function current(): LineItem
    {
        return parent::current();
    }

    public function for()
    {
        return LineItem::class;
    }
}
