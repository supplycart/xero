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
            if ($this->xero->storage->is_internal) {
                $connected = $this->xero->refreshAccessTokensInternal();
            } else {
                $connected = $this->xero->refreshAccessTokens();
            }


            if (!$connected) {
                throw new NoActiveConnectionException();
            }
        }
    }

    /**
     * @param string $message
     * @param string $type
     * @return \Illuminate\Log\Logger|void
     */
    public function log(string $message, $type = 'info')
    {
        $channel = config('xero.log_channel');
        $debugMode = config('xero.debug');

        if (!$debugMode) {
            return;
        }

        if (!array_key_exists($channel, config('logging.channels'))) {
            $channel = config('logging.default');
        }

        return logs()->channel($channel)->$type($message);
    }
}
