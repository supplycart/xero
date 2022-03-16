<?php

namespace Supplycart\Xero\Actions;

use Exception;
use Supplycart\Xero\Data\Contact\Contact;

class GetContact extends Action
{
    /**
     * @param array $data
     * @return bool|\Supplycart\Xero\Data\Contact\Contact
     */
    public function handle(array $data)
    {
        try {
            if (filled(data_get($data, 'id'))) {
                return $this->findById(data_get($data, 'id'));
            }

            if (filled(data_get($data, 'name'))) {
                return $this->findByName(data_get($data, 'name'));
            }

            return false;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    private function findById($id)
    {
        return new Contact([]);
    }

    private function findByName($name)
    {
        return new Contact([]);
    }
}
