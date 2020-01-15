<?php

namespace Supplycart\Xero\Actions\Contact;

use Supplycart\Xero\Actions\Action;
use Supplycart\Xero\Data\Contact;

class CreateContact extends Action
{
    public function handle()
    {
        return new Contact([]);
    }
}
