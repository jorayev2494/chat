<?php

declare(strict_types=1);

namespace App\Services\Api\Auth\Email;

use App\Exceptions\Api\Auth\InvalidCredentialsException;
use App\Http\DTOs\Api\Auth\Email\LoginEmailRequestDTO;
use App\Http\DTOs\Api\Auth\Email\RegisterEmailRequestDTO;
use App\Models\Device;
use App\Models\User;
use App\Repositories\Contracts\Auth\Email\AuthorizationEmailRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\Api\Auth\Enums\GuardEnum;
use App\Traits\Auth\AuthorizationTrait;
use Illuminate\Support\Facades\Auth;

class AuthorizationEmailService
{

    use AuthorizationTrait;
    
    public function __construct(
        private readonly AuthorizationEmailRepositoryInterface $authorizationEmailModelRepository
    )
    {
        
    }

    /**
     * @param EmailRegisterRequestDTO $emailRegisterRequestDTO
     * @param GuardEnum $guardEnum
     * @return array
     */
    public function register(RegisterEmailRequestDTO $registerEmailRequestDTO, GuardEnum $guardEnum = GuardEnum::API): void
    {
        /** @var User $registeredUser */
        $registeredUser = $this->authorizationEmailModelRepository->registerEmail($registerEmailRequestDTO);
        $registeredUser->sendEmailVerificationNotification();
    }

    /**
     * @param LoginEmailRequestDTO $loginEmailRequestDTO
     * @param [type] $guardEnum
     * @return array
     */
    public function login(LoginEmailRequestDTO $loginEmailRequestDTO, GuardEnum $guardEnum = GuardEnum::API): array
    {
        /** @var string|bool $token */
        if (! $token = Auth::attempt(['email' => $loginEmailRequestDTO->email, 'password' => $loginEmailRequestDTO->password])) {
            throw new InvalidCredentialsException();
        }

        /** @var User $foundUser */
        $foundUser = $this->authorizationEmailModelRepository->findByOrFail('email', $loginEmailRequestDTO->email);

        /** @var Device $device */
        $device = $foundUser->addDevice($loginEmailRequestDTO->device_id);
        
        return $this->respondWithToken($token, $device);
    }
}