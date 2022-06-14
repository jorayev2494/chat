<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatResource;
use App\Http\Resources\MessageResource;
use App\Services\ChatService;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{

    public function __construct(
        private ChatService $service
    )
    {
        
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(int $id = null): JsonResponse
    {
        $result = $this->service->getChats($id);

        return response()->json(
            MessageResource::collection(
                $result
            )
        );
    }

    /**
     * @return JsonResponse
     */
    public function chats(): JsonResponse
    {
        $result = $this->service->chats();

        return response()->json(
            ChatResource::collection(
                $result
            )
        );
    }
}
