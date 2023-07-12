<?php

namespace Supplycart\Xero;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Supplycart\Xero\Contracts\Storage;

/**
 * @property string contact_id
 * @property string account_code
 * @property string uuid
 * @property \Carbon\Carbon expired_at
 * @property string tenant_id
 * @property string refresh_token
 * @method Builder tokenExpiring()
 */
class Xero extends Model implements Storage
{
    protected $table = 'xeros';

    protected $guarded = [];

    protected $casts = [
        'is_enabled' => 'boolean',
        'expired_at' => 'datetime',
        'is_internal' => 'boolean'
    ];

    /**
     * @param $uuid
     * @return \Supplycart\Xero\Contracts\Storage | \Supplycart\Xero\Xero
     */
    public static function findByUuid($uuid): Storage
    {
        return static::query()->firstOrCreate(['uuid' => $uuid]);
    }

    public function getUuid(): string
    {
        return (string) $this->uuid;
    }

    public function setAccessToken($accessToken): Storage
    {
        return $this->fill(['access_token' => $accessToken]);
    }

    public function getAccessToken(): string
    {
        return (string) $this->access_token;
    }

    public function setTenantID($tenantID): Storage
    {
        return $this->fill(['tenant_id' => $tenantID]);
    }

    public function getTenantID(): string
    {
        return (string) $this->tenant_id;
    }

    public function setAccountCode($accountCode): Storage
    {
        return $this->fill(['account_code' => $accountCode]);
    }

    public function getAccountCode(): string
    {
        return (string) $this->account_code;
    }

    public function setRefreshToken($refreshToken): Storage
    {
        return $this->fill(['refresh_token' => $refreshToken]);
    }

    public function getRefreshToken(): string
    {
        return (string) $this->refresh_token;
    }

    public function getExpiredAt(): Carbon
    {
        return $this->expired_at;
    }

    public function setExpiredAt(Carbon $expiredAt): Storage
    {
        $this->expired_at = $expiredAt;

        return $this;
    }

    public function getTenantName(): string
    {
        return (string) $this->tenant_name;
    }

    public function setTenantName($tenantName): Storage
    {
        return $this->fill(['tenant_name' => $tenantName]);
    }

    /**
     * @return bool
     */
    public function persist(): bool
    {
        return $this->save();
    }


    /**
     * @return \Supplycart\Xero\XeroManager
     */
    public function manager(): XeroManager
    {
        return XeroManager::init($this);
    }

    /**
     * Query for connections whose tokens are expiring in N minutes
     *
     * @param Builder $query
     * @return void
     */
    public function scopeTokenExpiring(Builder $query)
    {
        return $query->where('expired_at', '<=', now()->addMinutes(config('xero.token_refresh_countdown')));
    }
}
