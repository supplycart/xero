<?php

namespace Supplycart\Xero\Exceptions;

use Exception;

class InvalidActionException extends Exception
{
    /**
     * InvalidActionException constructor.
     */
    public function __construct($action)
    {
        parent::__construct("Invalid {$action} action!");
    }
}
