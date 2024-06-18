<?php

namespace Supplycart\Xero\Data\Invoice;

use Supplycart\Xero\Data\DataCollection;

class BillCollection extends DataCollection
{
    public function current(): Bill
    {
        return parent::current();
    }

    #[\Override]
    public function for()
    {
        return Bill::class;
    }
}
