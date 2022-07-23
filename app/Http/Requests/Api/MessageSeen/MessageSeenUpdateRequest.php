<?php

namespace App\Http\Requests\Api\MessageSeen;

use App\Services\Api\Auth\Enums\GuardEnum;
use Illuminate\Foundation\Http\FormRequest;

class MessageSeenUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->guard(GuardEnum::API->value)->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'chat_id' => 'required|integer|exists:chats,id',
            'message_ids' => 'required|array',
            'message_ids.*' => 'required|integer|exists:messages,id',
            'is_seen' => 'boolean',
        ];
    }
}
