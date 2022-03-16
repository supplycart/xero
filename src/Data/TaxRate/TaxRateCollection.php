<?php

namespace Supplycart\Xero\Data\TaxRate;

use Supplycart\Xero\Data\DataCollection;

class TaxRateCollection extends DataCollection
{
    public function current(): TaxRate
    {
        return parent::current();
    }

    public function for()
    {
        return TaxRate::class;
    }
}
