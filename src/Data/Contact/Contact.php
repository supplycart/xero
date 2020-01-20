<?php

namespace Supplycart\Xero\Data;

use Spatie\DataTransferObject\DataTransferObject;

class Contact extends DataTransferObject
{
    /**
     * @var string
     */
    public $ContactID;

    /**
     * @var string
     */
    public $ContactStatus;

    /**
     * @var string
     */
    public $Name;
}
