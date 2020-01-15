<?php

namespace Supplycart\Xero\Exceptions;

use Exception;

class UnhandledActionException extends Exception
{
    /**
     * InvalidAttributesException constructor.
     */
    public function __construct()
    {
        parent::__construct('Unhandled action!');
    }
}
