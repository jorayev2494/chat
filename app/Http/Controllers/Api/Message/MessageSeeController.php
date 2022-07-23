<?php

namespace App\Http\Controllers\Api\Message;

use App\Http\Controllers\Controller;
use App\Http\DTOs\Api\MessageSee\MessageSeeRequestDTO;
use App\Http\Requests\Api\MessageSeen\MessageSeenUpdateRequest;
use App\Services\Api\Message\MessageSeeService;
use Illuminate\Http\Response;

class MessageSeeController extends Controller
{

    public function __construct(
        private MessageSeeService $service
    )
    {
        $this->middleware('auth:api');
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(MessageSeenUpdateRequest $request): Response
    {
        $dataDTO = MessageSeeRequestDTO::makeFromRequest($request);
        $this->service->markMessageSeen($request->user(), $dataDTO);

        return response()->noContent();
    }
}
