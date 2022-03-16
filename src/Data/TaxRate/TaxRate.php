<?php

namespace Supplycart\Xero\Data\TaxRate;

use Supplycart\Xero\Data\Data;

class TaxRate extends Data
{
    public bool $ignoreMissing = true;

    public $Name;

    public $TaxType;

    public $TaxComponents;

    public $Status;

    public $ReportTaxType;

    public $CanApplyToAssets;

    public $CanApplyToEquity;

    public $CanApplyToExpenses;

    public $CanApplyToLiabilities;

    public $CanApplyToRevenue;

    public $DisplayTaxRate;

    public $EffectiveRate;

    public $Elements;

    public $HasErrors;

    public $ValidationErrors;
}
