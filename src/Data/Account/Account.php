<?php

namespace Supplycart\Xero\Data\Account;

use Spatie\DataTransferObject\DataTransferObject;

class Account extends DataTransferObject
{
    public $AccountID;

    public $Code;

    public $Name;

    public $Status;

    public $Type;

    public $TaxType;

    public $Description;

    public $Class;

    public $SystemAccount;

    public $EnablePaymentsToAccount;

    public $ShowInExpenseClaims;

    public $BankAccountType;

    public $ReportingCode;

    public $ReportingCodeName;

    public $HasAttachments;

    public $UpdatedDateUTC;

    public $AddToWatchlist;
}
