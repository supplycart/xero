<?php

namespace Supplycart\Xero\Data\Invoice;

use Supplycart\Xero\Data\Data;

/**
 * Class Invoice
 * @package Supplycart\Xero\Data
 */
class Invoice extends Data
{
    public bool $ignoreMissing = true;

    public $Type = 'ACCREC';

    public $InvoiceID;

    /**
     * @var \Supplycart\Xero\Data\Contact|array|object
     */
    public $Contact;

    public $Date;

    public $DueDate;

    public $Status;

    public $LineAmountTypes;

    /**
     * @var \Supplycart\Xero\Data\Invoice\LineItemCollection|array
     */
    public $LineItems;

    public $SubTotal;

    public $TotalTax;

    public $Total;

    public $TotalDiscount;

    public $UpdatedDateUTC;

    public $CurrencyCode;

    public $CurrencyRate;

    public $InvoiceNumber;

    public $Reference;

    public $BrandingThemeID;

    public $Url;

    public $SentToContact;

    public $ExpectedPaymentDate;

    public $PlannedPaymentDate;

    public $HasAttachments;

    public $RepeatingInvoiceID;

    public $Payments;

    public $CreditNotes;

    public $Prepayments;

    public $Overpayments;

    public $AmountDue;

    public $AmountPaid;

    public $CISDeduction;

    public $FullyPaidOnDate;

    public $AmountCredited;

    public $HasErrors;

    public $ValidationErrors;
}
