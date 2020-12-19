<?php

namespace App\Calculators;

use App\Structures\ResultProbability;

class MeetResultProbabilityCalculator
{
    const HOME_MEET_FACTOR = 2;
    const MAX_POSSIBLE_NON_DRAWN_PROBABILITY = 0.99;
    const MIN_POSSIBLE_NON_DRAWN_PROBABILITY = 0.01;

    public function handle(
        int $hostClubStrength,
        int $guestClubStrength
    ): ResultProbability
    {
        $this->validate($hostClubStrength, $guestClubStrength);

        $hostClubStrength = self::HOME_MEET_FACTOR * $hostClubStrength;

        $totalStrengthAmount = $hostClubStrength + $guestClubStrength;

        $nonDrawnProbability = min(
            abs($hostClubStrength - $guestClubStrength) / $totalStrengthAmount,
            self::MAX_POSSIBLE_NON_DRAWN_PROBABILITY
        );

        $nonDrawnProbability = max($nonDrawnProbability, self::MIN_POSSIBLE_NON_DRAWN_PROBABILITY);

        $drawnGameProbability = 1 - $nonDrawnProbability;

        $hostWinProbability = $hostClubStrength * $nonDrawnProbability / $totalStrengthAmount;

        $hostLoseProbability = $nonDrawnProbability - $hostWinProbability;

        return new ResultProbability(
            win: $hostWinProbability,
            drawn:$drawnGameProbability,
            lose: $hostLoseProbability
        );
    }

    private function validate(int ...$parameters)
    {
        foreach ($parameters as $a) {
            if ($a < 1 || $a > 10) {
                throw new \RuntimeException("Invalid Strength $a");
            }
        }
    }
}