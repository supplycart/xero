<?php

namespace Supplycart\Xero\Data\ManualJournal;

use Supplycart\Xero\Data\Data;

class JournalLineItem extends Data
{
    /**
     * Mandatory fields
     */
    public float $LineAmount;

    public string $AccountCode;

    /**
     * Optional fields
     */
    public ?string $Description;

    public ?string $TaxType;

    public ?string $Tracking;
}
