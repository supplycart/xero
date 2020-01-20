<?php

namespace Supplycart\Xero\Data\Connection;

use Spatie\DataTransferObject\DataTransferObjectCollection;
use Supplycart\Xero\Data\DataCollection;

class ConnectionCollection extends DataCollection
{
    public function current(): Connection
    {
        return parent::current();
    }

    public function for()
    {
        return Connection::class;
    }
}