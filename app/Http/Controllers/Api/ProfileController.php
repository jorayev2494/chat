<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Api\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * @var User|null $authUser
     */
    private ?User $authUser;

    public function __construct(
        private readonly ProfileService $service
    )
    {
        $this->middleware('auth:api');
        $this->authUser = auth()->guard('api')->user();
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        return response()->json(
            UserResource::make($this->authUser->loadMissing('country', 'phoneCountry'))
        );
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileUpdateRequest $request): JsonResponse
    {
        $result = $this->service->update($this->authUser, $request->all());

        return response()->json($result);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
