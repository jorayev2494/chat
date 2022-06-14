<?php

namespace App\Http\Controllers;

use App\Console\Commands\PingWebSocketCommand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class TestController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function pingWs(): JsonResponse
    {
        $result = Bus::dispatch(new PingWebSocketCommand);

        return response()->json($result);
    }
}
