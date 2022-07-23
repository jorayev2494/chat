<?php

namespace App\Exceptions\Api\Chat;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ChatAlreadyCreatedException extends Exception
{
    /**
     * @var int $code
     */
    protected $code = Response::HTTP_BAD_REQUEST;

    /**
     * @var string $message
     */
    protected $message = 'Your chat already created';

    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request): JsonResponse
    {
        return response()->json([
                'message' => $this->message
            ],
            $this->code
        );
    }
}
