<?php

use Illuminate\Support\Facades\Route;
use Supplycart\Xero\Http\Controllers\AccountController;
use Supplycart\Xero\Http\Controllers\AuthController;
use Supplycart\Xero\Http\Controllers\ContactController;
use Supplycart\Xero\Http\Controllers\OrganisationController;
use Supplycart\Xero\Http\Controllers\StatusController;
use Supplycart\Xero\Http\Controllers\TaxRateController;

Route::prefix('oauth2')->group(function () {
    Route::get('/', [AuthController::class, 'authenticate']);

    Route::get('/redirect', [AuthController::class, 'redirect']);
});

Route::prefix('{uuid}')->group(function () {
    Route::get('/contacts', [ContactController::class, 'index']);

    Route::get('/status', [StatusController::class, 'show']);
    Route::put('/status', [StatusController::class, 'update']);

    Route::get('/organisations', [OrganisationController::class, 'index']);

    Route::get('/accounts', [AccountController::class, 'index']);

    Route::get('/tax-rates', [TaxRateController::class, 'index']);
});
