<?php

namespace Supplycart\Xero\Data\History;

use Supplycart\Xero\Data\Data;

/**
 * Class History
 * @package Supplycart\Xero\Data
 */
class History extends Data
{
    public bool $ignoreMissing = true;

    public $Changes;

    public $DateUTC;

    public $User;

    public $Details;

    public $HasErrors;

    public $ValidationErrors;
}
