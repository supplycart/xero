<?php

namespace Supplycart\Xero\Data\Invoice;

use Supplycart\Xero\Data\DataCollection;

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
