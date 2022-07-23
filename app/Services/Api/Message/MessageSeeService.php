<?php

declare(strict_types=1);

namespace App\Services\Api\Message;

use App\DTOs\MessageSee\MessageSeeDTO;
use App\Http\DTOs\Api\MessageSee\MessageSeeRequestDTO;
use App\Models\User;
use App\Repositories\MessageSeeRepository;

class MessageSeeService
{

    public function __construct(
        private MessageSeeRepository $repository
    )
    {
        
    }

    /**
     * @param User $user
     * @param MessageSeeDTO $dataDTO
     * @return void
     */
    public function markMessageSeen(User $user, MessageSeeDTO $dataDTO): void
    {
        $this->repository->markMessagesSeenByMessageIds($user->id, $dataDTO);
    }
}