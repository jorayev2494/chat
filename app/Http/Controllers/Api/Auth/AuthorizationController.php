<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\DTOs\Api\Auth\Email\LoginEmailRequestDTO;
use App\Http\DTOs\Api\Auth\Email\RegisterEmailRequestDTO;
use App\Http\Requests\Api\Auth\Email\AuthorizationEmailLoginRequest;
use App\Http\Requests\Api\Auth\Email\AuthorizationEmailRegisterRequest;
use App\Services\Api\Auth\Email\AuthorizationEmailService;
use Illuminate\Http\JsonResponse;

class AuthorizationController extends Controller
{

    public function __construct(
        private readonly AuthorizationEmailService $authorizationEmailService
    )
    {
        $this->middleware('guest:api');
    }

    public function register(
        AuthorizationEmailRegisterRequest $request
    ): JsonResponse
    {
        $dataDTO = RegisterEmailRequestDTO::makeFromRequest($request);
        $result = $this->authorizationEmailService->register($dataDTO);

        return response()->json($result);
    }

    public function login(
        AuthorizationEmailLoginRequest $request
    ): JsonResponse
    {
        $dataDTO = LoginEmailRequestDTO::makeFromRequest($request);
        $result = $this->authorizationEmailService->login($dataDTO);

        return response()->json($result);
    }
}
