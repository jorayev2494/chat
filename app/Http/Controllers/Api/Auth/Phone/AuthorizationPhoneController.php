<?php

namespace App\Http\Controllers\Api\Auth\Phone;

use App\Http\Controllers\Controller;
use App\Http\DTOs\Api\Auth\Phone\LoginPhoneRequestDTO;
use App\Http\DTOs\Api\Auth\Phone\RegisterPhoneCodeRequestDTO;
use App\Http\DTOs\Api\Auth\Phone\RegisterPhoneRequestDTO;
use App\Http\Requests\Api\Auth\Phone\AuthorizationPhoneCodeRegisterRequest;
use App\Http\Requests\Api\Auth\Phone\AuthorizationPhoneLoginRequest;
use App\Http\Requests\Api\Auth\Phone\AuthorizationPhoneRegisterController;
use App\Http\Requests\Api\Auth\Phone\AuthorizationPhoneRegisterRequest;
use App\Services\Api\Auth\Phone\AuthorizationPhoneService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorizationPhoneController extends Controller
{

    public function __construct(
        private readonly AuthorizationPhoneService $service
    )
    {
        
    }

    public function registerCode(AuthorizationPhoneCodeRegisterRequest $request): JsonResponse
    {
        $dataDTO = RegisterPhoneCodeRequestDTO::makeFromRequest($request);
        $result = $this->service->registerCode($dataDTO);

        return response()->json($result);
    }

    public function getAccount(AuthorizationPhoneRegisterRequest $request): JsonResponse
    {
        $dataDTO = LoginPhoneRequestDTO::makeFromRequest($request);
        $result = $this->service->login($dataDTO);

        return response()->json($result);
    }

    public function login(AuthorizationPhoneLoginRequest $request): JsonResponse
    {
        $dataDTO = LoginPhoneRequestDTO::makeFromRequest($request);
        $result = $this->service->login($dataDTO);

        return response()->json($result);
    }
}
