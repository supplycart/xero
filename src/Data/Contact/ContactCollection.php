<?php

namespace Supplycart\Xero\Data\Contact;

use Supplycart\Xero\Data\DataCollection;

class ContactCollection extends DataCollection
{
    public function current(): Contact
    {
        return parent::current();
    }

    #[\Override]
    public function for()
    {
        return Contact::class;
    }
}
