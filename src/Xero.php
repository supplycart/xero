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

    /**
     * @param $uuid
     * @return \Supplycart\Xero\Contracts\Storage | \Supplycart\Xero\Xero
     */
    #[\Override]
    public static function findByUuid($uuid): Storage
    {
        return static::query()->firstOrCreate(['uuid' => $uuid]);
    }

    #[\Override]
    public function getUuid(): string
    {
        return (string) $this->uuid;
    }

    #[\Override]
    public function setAccessToken($accessToken): Storage
    {
        return $this->fill(['access_token' => $accessToken]);
    }

    #[\Override]
    public function getAccessToken(): string
    {
        return (string) $this->access_token;
    }

    #[\Override]
    public function setTenantID($tenantID): Storage
    {
        return $this->fill(['tenant_id' => $tenantID]);
    }

    #[\Override]
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

    #[\Override]
    public function setRefreshToken($refreshToken): Storage
    {
        return $this->fill(['refresh_token' => $refreshToken]);
    }

    #[\Override]
    public function getRefreshToken(): string
    {
        return (string) $this->refresh_token;
    }

    #[\Override]
    public function getExpiredAt(): Carbon
    {
        return $this->expired_at;
    }

    #[\Override]
    public function setExpiredAt(Carbon $expiredAt): Storage
    {
        $this->expired_at = $expiredAt;

        return $this;
    }

    #[\Override]
    public function getTenantName(): string
    {
        return (string) $this->tenant_name;
    }

    #[\Override]
    public function setTenantName($tenantName): Storage
    {
        return $this->fill(['tenant_name' => $tenantName]);
    }

    /**
     * @return bool
     */
    #[\Override]
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
     * @return void
     */
    public function scopeTokenExpiring(Builder $query)
    {
        return $query->where('expired_at', '<=', now()->addMinutes(config('xero.token_refresh_countdown')));
    }
    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'expired_at' => 'datetime',
            'is_internal' => 'boolean'
        ];
    }
}
