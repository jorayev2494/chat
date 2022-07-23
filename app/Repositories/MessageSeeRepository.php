<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTOs\MessageSee\MessageSeeDTO;
use App\Http\DTOs\Api\MessageSee\MessageSeeRequestDTO;
use App\Models\MessageSee;
use App\Repositories\Base\BaseModelRepository;
use Illuminate\Database\PostgresConnection;
use Illuminate\Support\Facades\DB;

class MessageSeeRepository extends BaseModelRepository
{
    protected function getModel(): string
    {
        return MessageSee::class;
    }

    public function markMessagesSeenByMessageIds(int $userId, MessageSeeDTO $dataDto): void
    {
        DB::transaction(function () use($userId, $dataDto): void {
            $unreadMessages = $this->getModeClone()->newQuery()
                ->where('chat_id', $dataDto->chat_id)
                ->where('user_id', '!=', $userId)
                ->where('is_seen', !$dataDto->is_seen)
                ->whereIn('message_id', $dataDto->message_ids)
                ->get();
            
            $unreadMessages->each->update($dataDto->only('is_seen')->toArray());
        });
    }
}