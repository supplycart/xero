<?php

namespace Supplycart\Xero;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Supplycart\Xero\Actions\Action;
use Supplycart\Xero\Contracts\Storage;
use Supplycart\Xero\Data\Connection\ConnectionCollection;
use Supplycart\Xero\Data\Contact\ContactCollection;
use Supplycart\Xero\Data\PurchaseOrder\PurchaseOrder;
use Supplycart\Xero\Data\Token;
use Supplycart\Xero\Exceptions\InvalidActionException;
use Supplycart\Xero\Exceptions\UnhandledActionException;
use Supplycart\Xero\Http\Controllers\AccountController;
use Supplycart\Xero\Http\Controllers\AuthController;
use Supplycart\Xero\Http\Controllers\ContactController;
use Supplycart\Xero\Http\Controllers\OrganisationController;
use Supplycart\Xero\Http\Controllers\StatusController;
use Supplycart\Xero\Http\Controllers\TaxRateController;
use Supplycart\Xero\Data\Contact\AccountCollection;

/**
 * Class Xero
 * @package Supplycart\Xero
 *
 * @method authenticate()
 * @method redirect(string $code)
 * @method createPurchaseOrder(PurchaseOrder $purchaseOrder)
 * @method refreshAccessTokens()
 * @method ContactCollection getContacts(array $params)
 * @method array getOrganisation()
 * @method AccountCollection getAccounts(array $params, ?string $ifModifiedSince)
 * @method ConnectionCollection getConnections()
 * @method disconnect()
 * @method getTaxRates(array $where)
 * @method Token|null getToken(string $code)
 * @method PurchaseOrder getPurchaseOrder(string $poNumber)
 * @method PurchaseOrder updatePurchaseOrder(PurchaseOrder $purchaseOrder)
 * @method ItemCollection getItems(array $params, ?string $ifModifiedSince)
 * @method createAttachment(string $endpoint, string $guid, string $filename, string $contentType, $content)
 * @method createItems(array $data)
 */
class XeroManager
{
    /**
     * Xero constructor.
     */
    public function __construct(public Client $client, public Storage $storage)
    {
    }

    public static function init(Storage $storage)
    {
        return new static(new Client(), $storage);
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
            throw $e;
        } catch (\Exception $e) {
            $action->log($e->getMessage(), 'error');
            throw $e;
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

    /**
     * Register routes
     */
    public static function routes()
    {
        Route::prefix('xero')->group(function () {
            Route::prefix('oauth2')->group(function () {
                Route::get('/', [AuthController::class, 'authenticate']);
                Route::get('/internal', [AuthController::class, 'authenticateInternal']);

                Route::get('/redirect', [AuthController::class, 'redirect']);
                Route::get('/redirect/internal', [AuthController::class, 'redirectInternal']);
            });

            Route::prefix('{uuid}')->group(function () {
                Route::get('/contacts', [ContactController::class, 'index']);

                Route::get('/status', [StatusController::class, 'show']);
                Route::put('/status', [StatusController::class, 'update']);

                Route::get('/organisations', [OrganisationController::class, 'index']);

                Route::get('/accounts', [AccountController::class, 'index']);

                Route::get('/tax-rates', [TaxRateController::class, 'index']);
            });
        });
    }
}
