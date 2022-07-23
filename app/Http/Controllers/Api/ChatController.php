<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Message\MessageCreateRequest;
use App\Http\Requests\Api\Message\MessageStoreRequest;
use App\Http\Resources\ChatResource;
use App\Http\Resources\MessageResource;
use App\Models\User;
use App\Services\ChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    /**
     * @var User|null $authUser
     */
    private ?User $authUser;

    public function __construct(
        private ChatService $service
    )
    {
        $this->authUser = auth()->guard('api')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $result = $this->service->getUserChats($this->authUser);

        return response()->json(ChatResource::collection($result));
    }

    public function create(MessageCreateRequest $request): JsonResponse
    {
        $result = $this->service->create($this->authUser, $request->validated());

        return response()->json(MessageResource::make($result));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageStoreRequest $request): JsonResponse
    {
        $result = $this->service->store($this->authUser, $request->validated());

        return response()->json(MessageResource::make($result));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): JsonResponse
    {
        $result = $this->service->show($this->authUser, $id);

        return response()->json(MessageResource::collection($result));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $result = $this->service->update($this->authUser, $id, $request->all());

        return response()->json(MessageResource::make($result));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): Response
    {
        $this->service->delete($this->authUser, $id);

        return response()->noContent();
    }
}
