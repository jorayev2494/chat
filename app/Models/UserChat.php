<?php

namespace App\Models;

use App\Http\Resources\ChatResource;
use App\Repositories\ChatRepository;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserChat extends Pivot
{

    use BroadcastsEvents;

    public $table = 'users_chats';

    /** @var array $fillable */
    protected $fillable = [
        'confirmed_at',
        'is_private'
    ];

    /**
     * @param string $event
     * @return void
     */
    public function broadcastOn(string $event): array
    {
        return [
            new PrivateChannel("chat_user.{$this->user_id}")
        ];
    }

    /**
     * @param string $event
     * @return string
     */
    public function broadcastAs(string $event): string
    {
        return match($event) {
            'created' => 'chat_user.created',
            default => $event
        };
    }

    /**
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'chat_user' => ChatResource::make(
                app()->call(ChatRepository::class . '@findUserChat', ['userId' => $this->user_id, 'chatId' => $this->chat_id])
            )
        ];
    }

    /**
     * @return BelongsTo
     */
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
