<?php

namespace App\Models;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\BroadcastableModelEventOccurred;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageSee extends Model
{
    use HasFactory;
    use BroadcastsEvents;

    /**
     * @var array $fillable
     */
    public $fillable = [
        'chat_id',
        'user_id',
        'message_id',
        'is_seen',
    ];

    /**
     * @var array $casts
     */
    public $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * @param string $event
     * @return BroadcastableModelEventOccurred
     */
    protected function newBroadcastableEvent(string $event): BroadcastableModelEventOccurred
    {
        return (new BroadcastableModelEventOccurred($this, $event))->dontBroadcastToCurrentUser();
    }

    public function broadcastOn(string $event): array
    {
        return [
            new PrivateChannel("chat.messages_see.{$this->chat_id}")
        ];
    }

    /**
     * @return string
     */
    public function broadcastAs(string $event): string
    {
        return match ($event) {
            'created' => 'message_see.sent',
            'updated' => 'message_see.updated',
            'deleted' => 'message_see.deleted',
            default => $event
        };
    }

    /**
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'message_see' => $this->toArray()
        ];
    }
}
