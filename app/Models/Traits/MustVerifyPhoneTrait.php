<?php

namespace App\Models\Traits;

use Illuminate\Auth\Notifications\VerifyEmail;

trait MustVerifyPhoneTrait
{
    /**
     * @return bool
     */
    public function hasVerifiedPhone(): bool
    {
        return ! is_null($this->phone_verified_at);
    }

    /**
     * @return bool
     */
    public function markPhoneAsVerified(): bool
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * @return void
     */
    public function sendPhoneVerificationNotification(): void
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * @return string
     */
    public function getPhoneForVerification(): string
    {
        return $this->phone;
    }
}
