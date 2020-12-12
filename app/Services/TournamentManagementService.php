<?php

namespace App\Services;

use App\Models\Club;
use App\Models\Meet;
use App\Models\TournamentTableEntry;
use Illuminate\Support\Collection;

class TournamentManagementService
{
    public function getTournamentTable(): Collection
    {
        return TournamentTableEntry::orderBy('position')->get();
    }

    public function coinToss(): void
    {
        $this->cleanOldSeasonData();
        $this->createMeetsForAllPairs();
        $this->orderMeets();
    }

    private function cleanOldSeasonData()
    {
        Meet::truncate();
        TournamentTableEntry::truncate();
    }

    private function createMeetsForAllPairs()
    {
        $clubs = Club::all();

        $clubs->each(
            fn($hostClub, $key) => $clubs->except($key)->each(
                fn($guestClub) => Meet::createMeetForClubs($hostClub,$guestClub)
            )
        );
    }

    private function orderMeets()
    {
        Meet::all()->each(fn($meet) => $this->setTourNumber($meet));
    }

    private function setTourNumber($meet)
    {
        static $tourClubs = [
            1 => []
        ];

        $tourToTryAttaching = 1;

        while (!$meet->tour_number){
            if ($this->isAnyOfClubsAlreadyInThisTour($meet, $tourClubs[$tourToTryAttaching])) {
                $tourToTryAttaching++;
                continue;
            }

            $meet->tour_number = $tourToTryAttaching;

            $tourClubs[$tourToTryAttaching][] = $meet->hostClub->id;
            $tourClubs[$tourToTryAttaching][] = $meet->guestClub->id;
        }
    }

    /**
     * @param $meet
     * @param array $clubsOfThisTourIds
     * @return bool
     */
    private function isAnyOfClubsAlreadyInThisTour($meet, array $clubsOfThisTourIds): bool
    {
        return in_array($meet->hostClub->id, $clubsOfThisTourIds)
            || in_array($meet->guestClub->id, $clubsOfThisTourIds);
    }
}
