<?php

namespace Supplycart\Xero\Actions;

use Supplycart\Xero\Contracts\ShouldCheckConnection;
use Supplycart\Xero\Exceptions\NoActiveConnectionException;
use Supplycart\Xero\Exceptions\UnhandledActionException;
use Supplycart\Xero\XeroManager;

abstract class Action
{
    /**
     * @var \Supplycart\Xero\XeroManager
     */
    protected $xero;

    /**
     * CreatePurchaseOrder constructor.
     *
     * @param \Supplycart\Xero\XeroManager $xero
     * @throws \Supplycart\Xero\Exceptions\UnhandledActionException
     * @throws \Supplycart\Xero\Exceptions\NoActiveConnectionException
     */
    public function __construct(XeroManager $xero)
    {
        $this->xero = $xero;

        if (!method_exists($this, 'handle')) {
            throw new UnhandledActionException();
        }

        if ($this instanceof ShouldCheckConnection) {
            $this->checkConnection();
        }
    }

    /**
     * @throws \Supplycart\Xero\Exceptions\NoActiveConnectionException
     */
    public function checkConnection()
    {
        if (!$this->xero->isConnected()) {
            $connected = $this->xero->refreshAccessTokens();

            if (!$connected) {
                throw new NoActiveConnectionException;
            }
        }
    }

    /**
     * @param null $message
     * @return \Illuminate\Log\Logger
     */
    public function log($message = null)
    {
        $channel = config('xero.log_channel');

        if (!array_key_exists($channel, config('logging.channels'))) {
            $channel = config('logging.default');
        }

        return $message ? logs()->channel($channel)->info($message) : logs()->channel();
    }
}
