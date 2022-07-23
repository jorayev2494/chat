<?php

namespace App\Models;

use App\Models\Traits\MustVerifyPhoneTrait;
use App\Models\Base\JWTAuth;
use App\Models\Traits\MustVerifyEmailTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class User extends JWTAuth 
{
    use HasFactory;
    use Notifiable;
    use MustVerifyEmailTrait;
    use MustVerifyPhoneTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'avatar',
        'email',
        'phone',
        'phone_country_id',
        'country_id',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'timestamp',
        'phone_verified_at' => 'timestamp',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * @var array $append
     */
    protected $appends = [
        'full_name'
    ];

    /**
     * @return Attribute
     */
    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => !empty($fullName = "{$this->first_name} {$this->last_name}") ? $fullName : null
        );
    }

    /**
     * @return BelongsToMany
     */
    public function myChats(): HasMany
    {
        return $this->hasMany(Chat::class, 'user_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, UserChat::class);
    }

    /**
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'user_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function messagesSees(): HasMany
    {
        return $this->hasMany(MessageSee::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function devices(): HasMany
    {
        return $this->hasMany(Device::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function codes(): HasMany
    {
        return $this->hasMany(UserCode::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function phoneCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'phone_country_id', 'id');
    }

    /**
     * @return Attribute
     */
    public function avatar(): Attribute
    {
        return Attribute::make(
            get: static function (?string $value): ?string {
                if (is_null($value)) {
                    return null;
                }

                if (filter_var($value, FILTER_VALIDATE_URL)) {
                    return $value;
                }

                return config('app.url') . "/storage/{$value}";
            }
        );
    }
}
