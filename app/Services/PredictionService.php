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
        return $this->getTournamentTableEntries()->map(
            fn($tournamentTableEntry) => $this->getPredictionEntry($tournamentTableEntry)->toArray()
        )
            ->sortByDesc('championship_probability')
            ->sortBy('current_position')
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
            $tournamentTableEntry->club->tournamentTableEntry->position,
            $this->calculateChampionshipProbability(
                $tournamentTableEntry->position,
                $tournamentTableEntry->club,
            )
        );
    }

    private function calculateChampionshipProbability(int $position, Club $club): float
    {
        if ($this->tournamentFinished($club)) {
            return 1 === $position;
        }

        return
            $this->probabilityToOvertakeLeader($club) *
            (1 - $this->probabilityOthersOvertakeLeader($club))
            ;

    }

    private function tournamentFinished(Club $club): bool
    {
        return 0 === $club->meetsToPlay()->count();
    }

    private function probabilityToOvertakeLeader(Club $club):float
    {
        return $this->getCalculatedProbabilities()[$club->id];
    }

    private function getCalculatedProbabilities(): Collection
    {
        static $probabilities = null;

        if (null === $probabilities) {
            $probabilities = $this->getTournamentTableEntries()->mapWithKeys(
                fn(TournamentTableEntry $tournamentTableEntry) => [
                    $tournamentTableEntry->club->id =>
                        $this->calculateOvertakeLeaderProbability(
                            $tournamentTableEntry->points,
                            $tournamentTableEntry->club
                        )
                ]
            );
        }

        return $probabilities;
    }

    private function calculateOvertakeLeaderProbability($points, Club $club): float
    {
        if ($this->cannotReachLeader($points, $club)) {
            return 0;
        }

        $resultProbabilities = $club->meetsToPlay->map(
            fn(Meet $meet) => MeetResultProbabilityCalculator::handle(
                $this->getStatisticalStrength($meet->hostClub),
                $this->getStatisticalStrength($meet->guestClub)
            )
        );

        return ReachPointsSumProbabilityCalculator::handle(
            $this->getPointsToReachLeader($points),
            $resultProbabilities
        );
    }

    private function cannotReachLeader(int $availablePoints, Club $club): bool
    {
        return $this->getPointsToReachLeader($availablePoints) > ($club->meetsToPlay()->count() * 3);
    }

    private function getPointsToReachLeader(int $availablePoints): int
    {
        return $this->getLeaderPoints() - $availablePoints;
    }

    private function getLeaderPoints(): int
    {
        return $this->getTournamentTableEntries()->where('position', 1)->first()->points;
    }

    private function getStatisticalStrength(Club $club): int
    {
        return $club->tournamentTableEntry->points
            /
            $this->getTournamentTableEntries()->sum('points')
            *
            100;
    }

    private function probabilityOthersOvertakeLeader(Club $club): float
    {
        return $this->getCalculatedProbabilities()
            ->except($club->id)
            ->reduce(
                fn($carry,$currentProbability) =>
                    SimpleProbabilityCalculator::compatibleSum($carry, $currentProbability),
                0
            );
    }
}
