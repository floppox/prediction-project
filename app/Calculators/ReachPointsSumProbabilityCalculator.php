<?php

namespace App\Calculators;

use App\Enums\PointsForResult;
use App\Structures\PointsProbability;
use App\Structures\PointsProbabilityAccumulator;
use App\Structures\ResultProbability;
use Illuminate\Support\Collection;

class ReachPointsSumProbabilityCalculator
{
    public function handle($pointsToReachLeader, Collection $resultProbabilities)
    {
        $accumulatedPoints = app(PointsProbabilityAccumulator::class);

        $pointsProbabilities = $this->calculatePointsProbability($resultProbabilities);

        foreach ($pointsProbabilities as $pointsProbability) {
            if ($accumulatedPoints->points_sum > $pointsToReachLeader) {
                $accumulatedPoints->probability_product;
            }

            $accumulatedPoints->addPoints($pointsProbability->getPoints()) ;
            $accumulatedPoints->multiplyProbability($pointsProbability->getProbability());
        }

        return 0;
    }

    private function calculatePointsProbability(ResultProbability $resultProbabilities): Collection
    {
        return $resultProbabilities->map(
            fn(ResultProbability $resultProbability) => collect([
                new PointsProbability(
                    PointsForResult::DRAWN,
                    $resultProbability->win() + $resultProbability->drawn()
                ),
                new PointsProbability(
                    PointsForResult::WIN - PointsForResult::DRAWN,
                    $resultProbability->win()
                ),
            ])
        )
            ->collapse()
            ->sortBy(['probability', 'desc']);
    }
}