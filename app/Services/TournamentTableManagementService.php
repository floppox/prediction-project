<?php

namespace App\Services;

use App\Enums\MeetResult;
use App\Enums\MeetStatus;
use App\Models\Club;
use App\Models\Meet;
use App\Models\TournamentTableEntry;

class TournamentTableManagementService
{
    public function getTable()
    {
        return TournamentTableEntry::orderBy('position')->with('club')->get();
    }

    public function createTable()
    {
        Club::all()->each(
            fn(Club $club) => TournamentTableEntry::create(['club_id'=>$club->id])
        );
    }

    public function updateTable(Meet $meet)
    {
        $this->updateTableEntry($meet->hostClub);
        $this->updateTableEntry($meet->guestClub);
        $this->updatePositions();
    }

    private function updateTableEntry(Club $club)
    {
        TournamentTableEntry::where('club_id', $club->id)
            ->firstOrCreate(['club_id'=>$club->id])
            ->update(
                $this->getTableEntryCalculations($club),
            );
    }

    /**
     * @param Club $club
     * @return array
     */
    private function getTableEntryCalculations(Club $club): array
    {
        $meetsRelation = $club->meets()
            ->where('status', MeetStatus::COMPLETED)->get();

        $played = $meetsRelation->count();
        $win = $meetsRelation->where('pivot.result', '=', MeetResult::WIN)->count();
        $drawn = $meetsRelation->where('pivot.result', '=', MeetResult::DRAWN)->count();
        $lost = $meetsRelation->where('pivot.result', '=', MeetResult::LOSE)->count();
        $gf = $meetsRelation->sum('pivot.score');
        $ga = $meetsRelation->sum('pivot.missed_score');

        $gd = $gf - $ga;
        $points = $meetsRelation->sum('pivot.points');

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

    private function updatePositions()
    {
        TournamentTableEntry::orderByDesc('points')
            ->orderByDesc('gd')
            ->get()
            ->values()
            ->each(
                fn(TournamentTableEntry $entry, $index) =>
                    $entry->setPosition($index + 1)->save()
            );
    }
}
