<?php

namespace App\Calculators;

use App\Enums\PointsForResult;
use App\Structures\PointsProbability;
use App\Structures\ResultProbability;
use Illuminate\Support\Collection;

class ReachPointsSumProbabilityCalculator
{
    private ?Collection $probabilityChains = null;

    public function handle($pointsToReachLeader, Collection $resultProbabilities): float
    {
        $resultProbabilities->each(
            fn($meetResultProbability) => $this->appendProbabilityChains($meetResultProbability)
        );

        $result = $this->probabilityChains
            ->filter(
                fn($chain) => $pointsToReachLeader < collect($chain)->sum(
                        fn(PointsProbability $pointsProbability) => $pointsProbability->getPoints()
                    )
            )
            ->map(
                fn($chain) => collect($chain)->reduce(
                    fn(
                        float $carry,
                        PointsProbability $pointsProbability
                    ) => $carry * $pointsProbability->getProbability(),
                    1
                )
            )
            ->sum();

        $this->probabilityChains = null;

        return $result;
    }

    private function appendProbabilityChains(ResultProbability $meetResultProbability)
    {
        if (null === $this->probabilityChains) {
            $this->probabilityChains = collect([
                []
            ]);
        }

        $newProbabilityChains = [];

        foreach ($this->probabilityChains as $chain) {
            $newProbabilityChains[] = [ ...$chain, new PointsProbability(
                PointsForResult::WIN,
                $meetResultProbability->win()
            )];
            $newProbabilityChains[] = [ ...$chain, new PointsProbability(
                PointsForResult::DRAWN,
                $meetResultProbability->drawn()
            )];
        }

        $this->probabilityChains = collect($newProbabilityChains);
    }
}