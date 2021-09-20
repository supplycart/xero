<?php

namespace Supplycart\Xero\Data\Currency;

use Supplycart\Xero\Data\DataCollection;

class CurrencyCollection extends DataCollection
{
    public function current(): Currency
    {
        return parent::current();
    }

    public function for()
    {
        return Currency::class;
    }
}
