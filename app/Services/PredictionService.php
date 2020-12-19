<?php

namespace App\Services;

use App\Models\Club;
use App\Models\Meet;
use App\Models\TournamentTableEntry;
use App\Structures\PredictionEntry;
use Illuminate\Support\Collection;
use Facades\App\Calculators\MeetResultProbabilityCalculator;
use Facades\App\Calculators\ReachPointsSumProbabilityCalculator;
use Facades\App\Calculators\SimpleProbabilityCalculator;

class PredictionService
{
    public function getPredictionResults(): Collection
    {
        return $this->getTournamentTableEntries()
            ->map(
                fn($tournamentTableEntry) => $this->getPredictionEntry($tournamentTableEntry)->toArray()
            )
            ->sortByDesc('championship_probability')
            ->values();
    }

    private function getTournamentTableEntries(): Collection
    {
        static $tournamentTableEntries = null;

        if(null == $tournamentTableEntries) {
            $tournamentTableEntries = TournamentTableEntry::all();
        }

        return $tournamentTableEntries;
    }

    private function getPredictionEntry($tournamentTableEntry): PredictionEntry
    {
        return new PredictionEntry(
            $tournamentTableEntry->club->id,
            $tournamentTableEntry->club->name,
            $tournamentTableEntry->position,
            $this->calculateChampionshipProbability(
                $tournamentTableEntry->position ,
                $tournamentTableEntry->club,
            )
        );
    }

    private function calculateChampionshipProbability(?int $position, Club $club): float
    {
        if ($this->tournamentFinished($club)) {
            return 1 === $position ? 100 : 0;
        }

        if ($this->noMeetsCompleted($club)) {
            return round(100 / Club::count());
        }

        return round($this->getFinalProbability($club->id) * 100);
    }

    private function tournamentFinished(Club $club): bool
    {
        return 0 === $club->meetsToPlay()->count();
    }

    private function noMeetsCompleted(Club $club): bool
    {
        return 0 === $club->meetsPlayed()->count();
    }

    private function getFinalProbability(int $clubId): float
    {
        static $finalProbabilities = null;

        if (null !== $finalProbabilities) {
            return $finalProbabilities[$clubId];
        }

        $finalProbabilities = $this->getCalculatedOvertakeLeaderProbabilities()->map(
            fn(float $overtakeLederProbability, int $clubId) => $this->probabilityToOvertakeLeader($clubId) *
                (1 - $this->probabilityOthersOvertakeLeader($clubId))
        );

        if ($finalProbabilities->sum() == 0) {
            return 1 / $finalProbabilities->count();
        }

        $ratio = 1 / $finalProbabilities->sum();

        $finalProbabilities = $finalProbabilities->map(
            fn(float $finalProbability) => $finalProbability * $ratio
        );

        return $finalProbabilities[$clubId];
    }

    private function probabilityToOvertakeLeader(int $clubId):float
    {
        return $this->getCalculatedOvertakeLeaderProbabilities()[$clubId];
    }

    private function getCalculatedOvertakeLeaderProbabilities(): Collection
    {
        static $probabilities = null;

        if (null !== $probabilities) {
            return $probabilities;
        }

        $probabilities = $this->getTournamentTableEntries()->mapWithKeys(
            fn(TournamentTableEntry $tournamentTableEntry) => [
                $tournamentTableEntry->club->id =>
                    $this->calculateOvertakeLeaderProbability(
                        $tournamentTableEntry->points,
                        $tournamentTableEntry->club
                    )
            ]
        );

        return $probabilities;
    }

    private function calculateOvertakeLeaderProbability($points, Club $club): float
    {
        $resultProbabilities = $club->meetsToPlay->map(
            fn(Meet $meet) => MeetResultProbabilityCalculator::handle(
                $this->getStatisticalStrength($meet->hostClub),
                $this->getStatisticalStrength($meet->guestClub)
            )
        );

        $reachPointsProbability = ReachPointsSumProbabilityCalculator::handle(
            $this->getPointsToOvertakeLeader($points),
            $resultProbabilities
        );

        return $reachPointsProbability;
    }

    private function getPointsToOvertakeLeader(int $availablePoints): int
    {
        return $this->getLeaderPoints() - $availablePoints + 1;
    }

    private function getLeaderPoints(): int
    {
        return $this->getTournamentTableEntries()->where('position', 1)->first()->points;
    }

    private function getStatisticalStrength(Club $club): int
    {
        $ratio = $club->tournamentTableEntry->points / $this->getTournamentTableEntries()->sum('points');

        return max($ratio * 10, 1);
    }

    private function probabilityOthersOvertakeLeader(Int $clubId): float
    {
        return $this->getCalculatedOvertakeLeaderProbabilities()
            ->except($clubId)
            ->reduce(
                fn($carry,$currentProbability) =>
                    SimpleProbabilityCalculator::compatibleSum($carry, $currentProbability),
                0
            );
    }
}
