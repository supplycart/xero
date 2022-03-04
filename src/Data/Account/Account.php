<?php

namespace Supplycart\Xero\Data\Account;

use Spatie\DataTransferObject\DataTransferObject;

class Account extends DataTransferObject
{
    public bool $ignoreMissing = true;

    public $AccountID;

    public $Code;

    public $Name;

    public $Type;

    public $BankAccountNumber;

    public $Status;

    public $Description;

    public $BankAccountType;

    public $CurrencyCode;

    public $TaxType;

    public $EnablePaymentsToAccount;

    public $ShowInExpenseClaims;

    public $Class;

    public $SystemAccount;

    public $ReportingCode;

    public $ReportingCodeName;

    public $HasAttachments;

    public $UpdatedDateUTC;

    public $AddToWatchlist;

    public $HasErrors;

    public $ValidationErrors;
}
