<?php

namespace App\Repositories;

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
    public function getModel(): string
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
                                    ->whereHas('messages', static function (Builder $qb) use($userId): void {
                                        $qb->where('user_id', $userId);
                                    })
                                    ->with([
                                        'status:id,status',
                                        'members',
                                        'messages' => static function (HasMany $hasManyQuery): void {
                                            $hasManyQuery->orderBy('id', 'Desc')->first();
                                            $hasManyQuery->with('see:message_id,is_seen');
                                        }
                                    ])
                                    ->get();
    }


    /**
     * @return Collection
     */
    public function getChats(): Collection
    {
        return $this->getModeClone()->newQuery()
                                    ->with([
                                        'status:id,status',
                                        'members',
                                        'messages' => static function (HasMany $hasManyQuery): void {
                                            $hasManyQuery->orderBy('id', 'Desc')->first();
                                            $hasManyQuery->with('see:message_id,is_seen');
                                        }
                                    ])
                                    ->orderBy('id', 'Desc')
                                    ->get();
    }
}