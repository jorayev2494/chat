<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\DTOs\Api\Auth\Email\LoginEmailRequestDTO;
use App\Http\DTOs\Api\Auth\Email\RegisterEmailRequestDTO;
use App\Http\Requests\Api\Auth\Email\AuthorizationEmailLoginRequest;
use App\Http\Requests\Api\Auth\Email\AuthorizationEmailRegisterRequest;
use App\Models\User;
use App\Services\Api\Auth\Email\AuthorizationEmailService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    public function verify(Request $request): Response
    {
        /** @var User $foundUser */
        $foundUser = User::query()->findOrFail($request->query->getInt('id'));

        if (! hash_equals((string) $request->query->get('hash'), sha1($foundUser->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($foundUser->hasVerifiedEmail()) {
            return response()->noContent(204);
        }

        if ($foundUser->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        if ($response = $this->verified($request)) {
            return $response;
        }

        return response()->noContent(204);
    }

    /**
     * The user has been verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function verified(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Your account verified'
        ], 204);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([], 204);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([], 202);
    }
}
