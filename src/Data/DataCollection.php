<?php

namespace Supplycart\Xero\Data;

use Spatie\DataTransferObject\DataTransferObject;
use Supplycart\Xero\Data\Connection\Connection;

abstract class DataCollection extends DataTransferObject
{
    /**
     * @param array $collection
     */
    public function __construct(array $collection = [])
    {
        $singular = $this->for();

        $this->collection = [];

        foreach ($collection as $item) {
            $this->collection[] = new $singular((array) $item);
        }
    }

    abstract public function for();

    #[\Override]
    public function toArray(): array
    {
        $collection = $this->collection;

        foreach ($collection as $key => $item) {
            $collection[$key] = $item->toArray();
        }

        return $collection;
    }
}
