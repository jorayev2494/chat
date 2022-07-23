<?php

declare(strict_types=1);

namespace App\Services\Api\Auth\Phone;

use App\Http\DTOs\Api\Auth\Phone\LoginPhoneRequestDTO;
use App\Http\DTOs\Api\Auth\Phone\RegisterPhoneCodeRequestDTO;
use App\Http\DTOs\Api\Auth\Phone\RegisterPhoneRequestDTO;
use App\Models\Enums\UserCodeEnum;
use App\Models\User;
use App\Models\UserCode;
use App\Repositories\UserCodeRepository;
use App\Repositories\UserRepository;
use App\Traits\Auth\AuthorizationTrait;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Token;

class AuthorizationPhoneService
{
    
    use AuthorizationTrait;

    public function __construct(
        private readonly UserRepository $repository
    )
    {
        
    }

    /**
     * @param RegisterPhoneCodeRequestDTO $dataDTO
     * @return array
     */
    public function registerCode(RegisterPhoneCodeRequestDTO $dataDTO): array
    {
        /** @var User $createdAccount */
        $accountData = $dataDTO->only('phone', 'phone_country_id')->toArray();
        $createdAccount = $this->repository->getModeClone()->newQuery()->firstOrCreate($accountData, $accountData);

        /** @var UserCode $userCode */
        $userCode = $createdAccount->createCode(UserCodeEnum::REGISTER_PHONE);

        return [
            'phone_code' => $userCode->code
        ];
    }

    /**
     * @param LoginPhoneRequestDTO $dataDTO
     * @return array
     */
    public function login(LoginPhoneRequestDTO $dataDTO): array
    {
        $userCodeRepository = resolve(UserCodeRepository::class);
        /** @var UserCode $foundUserCode */
        $foundUserCode = $userCodeRepository->setColumns('id', 'user_id', 'type')->findByOrFail('code', $dataDTO->phone_code);

        if (! $foundUserCode->user->hasVerifiedPhone()) {
            $foundUserCode->user->markPhoneAsVerified();
        }

        /** @var string|bool $token */
        if (! $token = Auth::login($foundUserCode->user)) {
            dd(
                __METHOD__,
                'Auth Exception'
            );
        }

        $foundUserCode->delete();

        return $this->respondWithToken($token);
    }
}