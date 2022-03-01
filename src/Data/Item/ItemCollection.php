<?php

namespace Supplycart\Xero\Data\Item;

use Supplycart\Xero\Data\DataCollection;

class ItemCollection extends DataCollection
{
    public function current(): Item
    {
        return parent::current();
    }

    public function for()
    {
        return Item::class;
    }
}
