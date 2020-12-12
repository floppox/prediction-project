<?php

namespace App\Http\Controllers\Api;

use App\Services\TournamentManagementService;

class TournamentController extends AbstractApiController
{
    public function __construct(
        protected TournamentManagementService $tournamentManagementService
    ) {}

    public function showTable()
    {
        return $this->successResponse(
            $this->tournamentManagementService->getTournamentTable()
        );
    }

    public function coinToss()
    {
        $this->tournamentManagementService->coinToss();

        return $this->successResponse(
            $this->tournamentManagementService->getTournamentTable()
        );
    }
}
