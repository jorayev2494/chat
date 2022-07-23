<?php

namespace App\Exceptions\Api\Auth;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class InvalidCredentialsException extends Exception
{
    protected $code = Response::HTTP_FORBIDDEN;
    protected $message = 'Invalid credentials';

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
