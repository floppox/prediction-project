<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class AbstractApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param mixed $data
     * @return JsonResponse
     */
    protected function successResponse($data = null): JsonResponse
    {
        $responseFields = [
            'success' => 'true',
        ];

        if (null !== $data) {
            $responseFields['data'] = $data;
        }

        return response()->json($responseFields);
    }
}
