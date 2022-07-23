<?php

namespace App\DTOs\MessageSee;

use App\DTOs\Contracts\FromRequestDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class MessageSeeDTO extends DataTransferObject implements FromRequestDTO
{
    /**
     * @var string $message_id
     */
    public readonly string $chat_id;

    /**
     * @var string $message_id
     */
    public readonly array $message_ids;

    /**
     * @var boolean $is_seen
     */
    public readonly bool $is_seen;

    public static function makeFromRequest(Request|FormRequest $formRequest): self
    {
        return new self(
            chat_id: $formRequest->get('chat_id'),
            message_ids: $formRequest->get('message_ids'),
            is_seen: $formRequest->get('is_seen', true)
        );
    }
}