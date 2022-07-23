<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Services\Api\Public\CountryService;
use Illuminate\Http\JsonResponse;

class CountryController extends Controller
{

    public function __construct(
        private CountryService $service
    )
    {
        
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): JsonResponse
    {
        $result = $this->service->getPublicCounties();

        return response()->json($result);
    }
}
