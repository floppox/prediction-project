<?php

namespace App\Services;

use Facades\App\Calculators\ScheduleCalculator;
use App\Models\Club;
use App\Models\Meet;
use App\Models\TournamentTableEntry;
use Illuminate\Support\Collection;

class TournamentManagementService
{
    public function __construct(
        protected TournamentTableManagementService $tournamentTableManagementService
    ) {}

    public function getTournamentTable(): Collection
    {
        return $this->tournamentTableManagementService->getTable();
    }

    public function coinToss(): void
    {
        $this->cleanOldSeasonData();
        $this->createScheduledMeets();
        $this->tournamentTableManagementService->createTable();

    }

    private function cleanOldSeasonData()
    {
        TournamentTableEntry::truncate();

        Meet::all()->each(function(Meet $meet) {
            $meet->clubs()->detach();
            $meet->delete();
        });
    }

    private function createScheduledMeets()
    {
        $clubs = Club::all()->values();

        $scheduleTable =  ScheduleCalculator::handle($clubs->count());

        foreach ($scheduleTable as $tourIndex => $meets) {
            foreach ($meets as $meet) {
                $hostClubIndex = $meet[0];
                $guestClubIndex = $meet[1];

                if (-1 === $guestClubIndex) {
                    continue;
                }

                Meet::createMeetForClubs(
                    $clubs[$hostClubIndex],
                    $clubs[$guestClubIndex],
                    $tourIndex + 1
                );
            }
        }
    }
}
