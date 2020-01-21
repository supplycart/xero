<?php

namespace Supplycart\Xero\Data;

use Spatie\DataTransferObject\DataTransferObject;

class Contact extends DataTransferObject
{
    /**
     * @var string
     */
    public $ContactID;

    /**
     * @var string
     */
    public $ContactStatus;

    /**
     * @var string
     */
    public $Name;

    public $FirstName;

    public $LastName;

    public $EmailAddress;

    public $SkypeUserName;

    public $Addresses;

    public $Phones;

    public $BankAccountDetails;

    public $TaxNumber;

    public $AccountsReceivableTaxType;

    public $AccountsPayableTaxType;

    public $DefaultCurrency;

    public $UpdatedDateUTC;

    public $ContactGroups;

    public $IsSupplier;

    public $IsCustomer;

    public $Balances;

    public $ContactPersons;

    public $HasAttachments;

    public $HasValidationErrors;
}