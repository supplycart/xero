<?php

namespace Supplycart\Xero\Data\Account;

use Supplycart\Xero\Data\DataCollection;

class AccountCollection extends DataCollection
{
    public function current(): Account
    {
        return parent::current();
    }

    #[\Override]
    public function for()
    {
        return Account::class;
    }
}
