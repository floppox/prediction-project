<?php

namespace App\Observers;

use App\Models\Meet;
use App\Services\TournamentTableManagementService;

class MeetObserver
{
    public function __construct(
        protected TournamentTableManagementService $tournamentTableManagementService
    ){}

    /**
     * Handle the Meet "saved" event.
     *
     * @param  \App\Models\Meet  $meet
     * @return void
     */
    public function saved(Meet $meet)
    {
        if (!$meet->clubs->count()) {
            return;
        }

        $this->tournamentTableManagementService->updateTable($meet);
    }
}
