<?php

namespace App\Models;

use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Message extends Model
{
    use HasFactory;
    use BroadcastsEvents;

    /**
     * @var array
     */
    public $fillable = [
        'chat_id',
        'user_id',
        'text'
    ];

    /**
     * @var array $casts
     */
    public $casts = [
        'chat_id',
        'user_id',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    /**
     * @return HasOne
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function see(): HasOne
    {
        return $this->hasOne(MessageSee::class, 'message_id', 'id');
    }

    /**
     * @return MorphMany
     */
    public function medias(): MorphMany
    {
        return $this->morphMany(Media::class, 'media_able', 'media_able_type', 'media_able_id');
    }
}
