<?php

namespace Supplycart\Xero\Data\Invoice;

use Supplycart\Xero\Data\Data;

/**
 * Class Bill
 * @package Supplycart\Xero\Data
 */
class Bill extends Data
{
    public $Type = 'ACCPAY';

    public $InvoiceID;

    public $InvoiceNumber;

    public $Date;

    public $DueDate;

    public $Status;

    public $SubTotal;

    public $TotalTax;

    public $Total;

    public $TotalDiscount;

    public $CurrencyCode;

    public $CurrencyRate;

    public $Reference;

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

    public $LineAmountTypes;

    public $HasErrors;

    public $ValidationErrors;

    /**
     * @var \Supplycart\Xero\Data\Contact|array|object
     */
    public $Contact;

    /**
     * @var \Supplycart\Xero\Data\Invoice\LineItemCollection|array
     */
    public $LineItems;
}
