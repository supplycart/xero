<?php

namespace Supplycart\Xero\Data\PurchaseOrder;

use Supplycart\Xero\Data\DataCollection;

class PurchaseOrderCollection extends DataCollection
{
    public function current(): PurchaseOrder
    {
        return parent::current();
    }

    #[\Override]
    public function for()
    {
        return PurchaseOrder::class;
    }
}
