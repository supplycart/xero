<?php

namespace Supplycart\Xero\Exceptions;

use Exception;

class NoActiveConnectionException extends Exception
{
    /**
     * InvalidActionException constructor.
     */
    public function __construct()
    {
        parent::__construct("Xero connection is not active!");
    }
}
