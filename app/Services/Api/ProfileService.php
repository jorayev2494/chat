<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    /**
     * @var array $relations
     */
    private array $relations = [
        'country',
        'phoneCountry'
    ];

    /**
     * @param User $user
     * @return User
     */
    public function index(User $user): User
    {
        return $user->fresh($this->relations);
    }

    /**
     * @param User $user
     * @param array $data
     * @return User
     */
    public function update(User $user, array $data): User
    {
        if (array_key_exists('avatar', $data)) {
            /** @var UploadedFile $avatar */
            $avatar = $data['avatar'];

            if ($avatarPath = $user->getRawOriginal('avatar')) {
                Storage::disk('public')->exists($avatarPath) ? Storage::disk('public')->delete($avatarPath) : null;
            }

            $data['avatar'] = $avatar->storePublicly("/avatars/{$user->id}", ['disk' => 'public']);
        }

        $user->update($data);

        return $user->fresh($this->relations);
    }
}