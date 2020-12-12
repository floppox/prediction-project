<?php

namespace App\Http\Controllers\Api;

use App\Services\PredictionService;
use Illuminate\Http\Request;

class PredictionController extends AbstractApiController
{
    public function __invoke(PredictionService $predictionService)
    {
        return $this->successResponse(
            $predictionService->getPredictionResults()
        );
    }
}
