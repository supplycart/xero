<?php

namespace Supplycart\Xero;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Supplycart\Xero\Actions\Action;
use Supplycart\Xero\Contracts\Storage;
use Supplycart\Xero\Data\Token;
use Supplycart\Xero\Events\XeroAuthenticated;
use Supplycart\Xero\Exceptions\InvalidActionException;
use Supplycart\Xero\Exceptions\UnhandledActionException;

/**
 * Class Xero
 * @package Supplycart\Xero
 *
 * @method authenticate(\Illuminate\Http\Request $request)
 * @method redirect(string $code)
 * @method createPurchaseOrder(array $array)
 * @method refreshAccessTokens()
 * @method \Supplycart\Xero\Data\Contact\ContactCollection getContacts()
 * @method array getOrganisation()
 * @method array getAccounts()
 * @method \Supplycart\Xero\Data\Connection\ConnectionCollection getConnections()
 * @method disconnect()
 * @method getTaxRates()
 * @method Token|null getToken($code)
 */
class XeroManager
{
    /**
     * @var \Supplycart\Xero\Contracts\Storage
     */
    public $storage;

    /**
     * @var \GuzzleHttp\Client
     */
    public $client;

    /**
     * Xero constructor.
     * @param \GuzzleHttp\Client $client
     * @param \Supplycart\Xero\Contracts\Storage $storage
     */
    public function __construct(Client $client, Storage $storage)
    {
        $this->client = $client;
        $this->storage = $storage;
    }

    public static function init(Storage $storage)
    {
        return new static(new Client(), $storage);
    }

    public static function routes()
    {
        Route::prefix('xero')->middleware('cors')->group(__DIR__ . '/../routes/xero.php');
    }

    /**
     * @param string | null $key
     *
     * @return array | string
     */
    public function config($key = null)
    {
        return config('xero.' . $key);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Supplycart\Xero\Exceptions\InvalidActionException
     * @throws \Supplycart\Xero\Exceptions\UnhandledActionException
     */
    public function __call($name, $arguments)
    {
        $action = Str::studly($name);
        $class = __NAMESPACE__ . '\\Actions\\' . $action;

        if (!class_exists($class)) {
            throw new InvalidActionException($action);
        }

        /** @var Action $action */
        $action = new $class($this);

        try {
            return $action->handle(...$arguments);
        } catch (UnhandledActionException $e) {
            throw $e;
        } catch (ClientException $e) {
            $action->log($e->getResponse()->getBody()->getContents(), 'error');
        } catch (\Exception $e) {
            $action->log($e->getMessage(), 'error');
        }
    }

    public function isAuthenticated()
    {
        return !!$this->storage->getAccessToken();
    }

    public function isConnected()
    {
        if (!$this->isAuthenticated()) {
            return false;
        }

        $connections = $this->getConnections();

        return !empty($connections);
    }
}
