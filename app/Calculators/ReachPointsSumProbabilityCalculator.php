<?php

namespace App\Calculators;

use App\Enums\PointsForResult;
use App\Structures\PointsProbability;
use App\Structures\ResultProbability;
use Facades\App\Calculators\FloatComparator;
use Facades\App\Calculators\SimpleProbabilityCalculator as SimpleProbabilityCalculatorFacade;
use Illuminate\Support\Collection;

class ReachPointsSumProbabilityCalculator
{
    private ?Collection $probabilityChains = null;

    public function handle($pointsToReachLeader, Collection $resultProbabilities): float
    {
        $this->refreshProbabilityChains();

        $probabilityChains = $this->filterChainsAllowingToReachLeader(
            $this->buildProbabilitiesChainForFuturesMatches($resultProbabilities),
            $pointsToReachLeader
        );

        $result = $probabilityChains
            ->map(fn($chain) => $this->calculateChainProbability(collect($chain)))
            ->sum();

        $this->validate($result);

        return $result;
    }

    private function calculateChainProbability(Collection $chain): float
    {
        return $chain->reduce(
            fn(float $carry, PointsProbability $pointsProbability) =>
                SimpleProbabilityCalculatorFacade::multiplication(
                    $carry, $pointsProbability->getProbability()
                ),
            1
        );
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

    private function buildProbabilitiesChainForFuturesMatches(Collection $resultProbabilities): Collection
    {
        $resultProbabilities->each(
            fn($meetResultProbability) => $this->appendProbabilityChains($meetResultProbability)
        );

        return $this->probabilityChains;
    }

    private function filterChainsAllowingToReachLeader(Collection $probabilityChains, $pointsToReachLeader): Collection
    {
        return $probabilityChains->filter(
            fn($chain) => $pointsToReachLeader <= collect($chain)->sum(
                fn(PointsProbability $pointsProbability) => $pointsProbability->getPoints()
            )
        );
    }

    private function refreshProbabilityChains()
    {
        $this->probabilityChains = null;
    }

    private function validate(float ...$parameters)
    {
        foreach ($parameters as $a) {
            if (
                FloatComparator::firstGrater(0, $a) || FloatComparator::firstGrater($a, 1)
            ) {
                throw new \RuntimeException("Invalid Probability $a got in " . self::class);
            }
        }
    }
}