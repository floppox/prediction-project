<?php

namespace App\Http\Controllers\Api;

use App\Services\TourManagementService;

class TourController extends AbstractApiController
{
    public function __construct(
        protected TourManagementService $tourManagementService
    ) {}

    public function show(int $tour_number)
    {
        return $this->successResponse(
            $this->tourManagementService->getTour($tour_number)
        );
    }

    public function index()
    {
        return $this->successResponse(
            $this->tourManagementService->listTours()
        );
    }

    public function playNextTour()
    {
        $this->tourManagementService->playNextTour();

        return $this->successResponse(
            $this->tourManagementService->getLastPlayedTour()
        );
    }
}
