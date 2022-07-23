<?php

namespace App\Repositories;

use App\Http\Resources\ChatResource;
use App\Models\Chat;
use App\Repositories\Base\BaseModelRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatRepository extends BaseModelRepository
{
    /**
     * @return string
     */
    protected function getModel(): string
    {
        return Chat::class;
    }

    /**
     * @param integer $userId
     * @return Collection
     */
    public function getUserChats(int $userId): Collection
    {
        return $this->getModeClone()->newQuery()
                                    ->whereHas('members', static function (Builder $qb) use($userId): void {
                                        $qb->where('user_id', $userId);
                                    })
                                    ->withCount(['messagesSees as messages_unseen_count' => static function (Builder $qb) use($userId): void {
                                        $qb->where('user_id', $userId)->where('is_seen', false);
                                    }])
                                    ->with([
                                        'status:id,status',
                                        'members',
                                        'messages' => static function (HasMany $hasManyQuery): void {
                                            $hasManyQuery->orderBy('id', 'DESC')->first();
                                            $hasManyQuery->with('see:message_id,is_seen');
                                        }
                                    ])
                                    ->get();
    }

    /**
     * @param integer $userId
     * @return Collection
     */
    public function findUserChat(int $userId, int $chatId): Chat
    {
        return $this->getModeClone()->newQuery()
                                    ->whereHas('members', static function (Builder $qb) use($userId): void {
                                        $qb->where('user_id', $userId);
                                    })
                                    ->withCount(['messagesSees as messages_unseen_count' => static function (Builder $qb) use($userId): void {
                                        $qb->where('user_id', $userId)->where('is_seen', false);
                                    }])
                                    ->with([
                                        'status:id,status',
                                        'members',
                                        'messages' => static function (HasMany $hasManyQuery): void {
                                            $hasManyQuery->orderBy('id', 'DESC')->first();
                                            $hasManyQuery->with('see:message_id,is_seen');
                                        }
                                    ])
                                    ->findOrFail($chatId);
    }
}