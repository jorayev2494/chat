<?php

namespace App\Models\Base;

use App\Models\Enums\UserCodeEnum;
use App\Models\UserCode;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @mixin Model
 */
abstract class JWTAuth extends Authenticatable implements JWTSubject
{
    /**
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [

        ];
    }

    /**
     * @return Attribute
     */
    public function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value): string => $this->attributes['password'] = bcrypt($value)
        );
    }

    /**
     * @param CodeEnum $type
     * @param integer $min
     * @param integer $max
     * @return UserCodeEnum
     */
    public function createCode(UserCodeEnum $type, int $min = 100000, int $max = 999999, string $expiredAt = null): UserCode
    {
        $code = random_int($min, $max);
        $expiredAt = $expiredAt ?: now()->addHour();

        return $this->codes()->updateOrCreate(
            compact('type'),
            array_merge(compact('code', 'type'), ['expired_at' => $expiredAt])
        );
    }
}