<?php

namespace Supplycart\Xero\Data;

class Token extends Data
{
    /**
     * @var string
     */
    public $access_token;

    /**
     * @var string
     */
    public $id_token;

    /**
     * @var string
     */
    public $refresh_token;

    /**
     * @var string
     */
    public $token_type;

    /**
     * @var int
     */
    public $expires_in;

    /**
     * @var string
     */
    public $scope;
}
