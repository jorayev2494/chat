<?php

declare(strict_types=1);

namespace App\Services\Api\Auth\Email;

use App\Http\DTOs\Api\Auth\Email\LoginEmailRequestDTO;
use App\Http\DTOs\Api\Auth\Email\RegisterEmailRequestDTO;
use App\Repositories\Contracts\Auth\Email\AuthorizationEmailRepositoryInterface;
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
    public function register(RegisterEmailRequestDTO $registerEmailRequestDTO, GuardEnum $guardEnum = GuardEnum::API): array
    {
        $registeredModel = $this->authorizationEmailModelRepository->registerEmail($registerEmailRequestDTO);

        return [
            'message' => 'success',
            'model' => $registeredModel
        ];
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
            dd(
                __METHOD__,
                'error',
                401
            );
        }
        
        return $this->respondWithToken($token);
    }
}