<?php

declare(strict_types=1);

namespace App\Services\Api\Auth\Phone;

use App\Exceptions\Api\Auth\InvalidCredentialsException;
use App\Http\DTOs\Api\Auth\Phone\LoginPhoneRequestDTO;
use App\Http\DTOs\Api\Auth\Phone\RegisterPhoneCodeRequestDTO;
use App\Http\DTOs\Api\Auth\Phone\ResentCodeRequestDTO;
use App\Http\Requests\Api\Auth\Phone\AuthorizationResentCodeRequest;
use App\Models\Device;
use App\Models\Enums\UserCodeEnum;
use App\Models\User;
use App\Models\UserCode;
use App\Repositories\UserCodeRepository;
use App\Repositories\UserRepository;
use App\Traits\Auth\AuthorizationTrait;
use Illuminate\Support\Facades\Auth;

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
        /** @var UserCode $foundAccountCode */
        $foundAccountCode = $userCodeRepository->setColumns('id', 'user_id', 'type')->findByOrFail('code', $dataDTO->phone_code);

        if (! $foundAccountCode->user->hasVerifiedPhone()) {
            $foundAccountCode->user->markPhoneAsVerified();
        }

        /** @var string|bool $token */
        if (! $token = Auth::login($foundAccountCode->user)) {
            throw new InvalidCredentialsException();
        }

        /** @var Device $device */
        $device = $foundAccountCode->user->addDevice($dataDTO->device_id);

        $foundAccountCode->delete();

        return $this->respondWithToken($token, $device);
    }

    /**
     * @param ResentCodeRequestDTO $dataDTO
     * @return array
     */
    public function resendCode(ResentCodeRequestDTO $dataDTO): array
    {
        $fountAccount = $this->repository->findUserByPhoneCountryIdAndPhoneNumber($dataDTO->phone_country_id, $dataDTO->phone);
        /** @var UserCode $userCode */
        $userCode = $fountAccount->createCode(UserCodeEnum::REGISTER_PHONE);

        return [
            'phone_code' => $userCode->code
        ];
    }
}