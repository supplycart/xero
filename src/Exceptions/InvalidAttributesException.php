<?php

namespace Supplycart\Xero\Exceptions;

use Exception;

class InvalidAttributesException extends Exception
{
    /**
     * InvalidAttributesException constructor.
     * @param \Illuminate\Support\MessageBag $errors
     */
    public function __construct($errors)
    {
        parent::__construct('Invalid attributes! ' . $errors->first());
    }
}
