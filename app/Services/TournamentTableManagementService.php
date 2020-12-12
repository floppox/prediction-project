<?php

namespace App\Services;

use App\Enums\MeetResult;
use App\Enums\MeetStatus;
use App\Models\Club;
use App\Models\Meet;
use App\Models\TournamentTableEntry;

class TournamentTableManagementService
{

    public function updateTable(Meet $meet)
    {
        $this->updateTableEntry($meet->hostClub);
        $this->updateTableEntry($meet->guestClub);
        $this->updatePositions();
    }

    private function updateTableEntry(Club $hostClub)
    {
        $entry = TournamentTableEntry::where('club_id', $hostClub->id)
            ->firstOrCreate([])
            ->update($this->getTableEntryCalculations($hostClub));
    }

    /**
     * @param Club $hostClub
     * @return array
     */
    private function getTableEntryCalculations(Club $hostClub): array
    {
        $meetsRelation = $hostClub->meets()
            ->where('status', MeetStatus::COMPLETED);

        $played = $meetsRelation->count();
        $win = $meetsRelation->wherePivot('result', MeetResult::WIN)->count();
        $drawn = $meetsRelation->wherePivot('result', MeetResult::DRAWN)->count();
        $lost = $meetsRelation->wherePivot('result', MeetResult::LOSE)->count();
        $gf = $meetsRelation->sum('pivot.score');
        $ga = $meetsRelation->sum('pivot.missed_score');

        $gd = $gf - $ga;
        $points = $this->calculatePoints($win, $lost, $drawn);

        return [
            'played' => $played,
            'won' => $win,
            'drawn' => $drawn,
            'lost' => $lost,
            'gf' => $gf,
            'ga' => $ga,
            'gd' => $gd,
            'points' => $points,
        ];
    }

    /**
     * @param int $win
     * @param int $lost
     * @param int $drawn
     * @return int
     */
    private function calculatePoints(int $win, int $lost, int $drawn): int
    {
        return ($win - $lost) * 3 + $drawn;
    }

    private function updatePositions()
    {
        TournamentTableEntry::orderByDesc('points')
            ->orderByDesc('gd')
            ->get()
            ->each(
                fn(TournamentTableEntry $entry, $position) =>
                    $entry->update(['position', $position])
            );
    }
}
