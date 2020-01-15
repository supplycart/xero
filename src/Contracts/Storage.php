<?php

namespace Supplycart\Xero\Contracts;

use Carbon\Carbon;

interface Storage
{
    public static function findByUuid($uuid): Storage;

    public function getUuid(): string;

    public function setAccessToken($accessToken): Storage;

    public function getAccessToken(): string;

    public function setTenantID($tenantID): Storage;

    public function getTenantID(): string;

    public function setRefreshToken($refreshToken): Storage;

    public function getRefreshToken(): string;

    public function getExpiredAt(): Carbon;

    public function setExpiredAt(Carbon $expiredAt): Storage;

    public function persist(): bool;
}
