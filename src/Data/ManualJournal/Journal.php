<?php

namespace Supplycart\Xero\Data\ManualJournal;

use Supplycart\Xero\Data\Data;

class Journal extends Data
{
    /**
     * Mandatory fields
     */
    public string $Narration;

    public array $JournalLines;

    /**
     * Optional fields
     */
    public ?string $Date;

    public string $LineAmountTypes;

    public string $Status;

    public ?string $Url;

    public ?bool $ShowOnCashBasisReports;

    public $ValidationErrors;
}
