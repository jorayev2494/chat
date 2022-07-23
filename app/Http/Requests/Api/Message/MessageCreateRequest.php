<?php

namespace App\Http\Requests\Api\Message;

use App\Services\Api\Auth\Enums\GuardEnum;
use Illuminate\Foundation\Http\FormRequest;

class MessageCreateRequest extends FormRequest
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
            'user_id' => 'integer|exists:users,id',
            'text' => 'string|max:255',
            'medias' => 'array|max:2',
            'medias.*' => 'file|mime_types:image/*,video/*'
        ];
    }
}
