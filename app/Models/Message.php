<?php

namespace App\Models;

use App\Events\CreateMessageEvent;
use App\Http\Resources\MessageResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\BroadcastableModelEventOccurred;
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
        'chat_id' => 'integer',
        'user_id' => 'integer',
        'parent_id' => 'integer',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    /**
     * @param string $event
     * @return BroadcastableModelEventOccurred
     */
    protected function newBroadcastableEvent(string $event): BroadcastableModelEventOccurred
    {
        return (new BroadcastableModelEventOccurred($this, $event))->dontBroadcastToCurrentUser();
    }

    /**
     * @param string $event
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(string $event): array
    {
        return [
            new PrivateChannel("chat.{$this->chat_id}")
        ];
    }

    /**
     * @return string
     */
    public function broadcastAs(string $event): string
    {
        return match ($event) {
            'created' => 'message.sent',
            'updated' => 'message.updated',
            'deleted' => 'message.deleted',
            default => $event
        };
    }

    /**
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'message' => MessageResource::make($this->loadMissing('user', 'medias'))
        ];
    }

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
