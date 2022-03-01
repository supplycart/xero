<?php

namespace Supplycart\Xero\Data\Contact;

use Spatie\DataTransferObject\DataTransferObject;

class Contact extends DataTransferObject
{
    // Ignore missing properties that are not in use
    public bool $ignoreMissing = true;

    public $ContactID;

    public $ContactNumber;

    public $AccountNumber;

    public $ContactStatus;

    public $Name;

    public $FirstName;

    public $LastName;

    public $EmailAddress;

    public $SkypeUserName;

    public $BankAccountDetails;

    public $TaxNumber;

    public $AccountsReceivableTaxType;

    public $AccountsPayableTaxType;

    public $Addresses;

    public $Phones;

    public $IsSupplier;

    public $IsCustomer;

    public $DefaultCurrency;

    public $UpdatedDateUTC;

    public $ContactPersons;

    public $XeroNetworkKey;

    public $SalesDefaultAccountCode;

    public $PurchasesDefaultAccountCode;

    public $SalesTrackingCategories;

    public $PurchasesTrackingCategories;

    public $TrackingCategoryName;

    public $TrackingOptionName;

    public $PaymentTerms;

    public $ContactGroups;

    public $Website;

    public $BrandingTheme;

    public $BatchPayments;

    public $Discount;

    public $Balances;

    public $HasAttachments;

    public $HasValidationErrors;
}
