<?php

namespace App\Calculators;

use App\Structures\ResultProbability;

class MeetResultProbabilityCalculator
{
    const HOME_MEET_FACTOR = 2;

    public function handle(
        float|int $hostClubStrength,
        float|int $guestClubStrength
    ): ResultProbability
    {
        $hostClubStrength *= self::HOME_MEET_FACTOR;

        $totalStrengthAmount = $hostClubStrength + $guestClubStrength;

        $drawnGameProbability =
            abs($hostClubStrength - $guestClubStrength) / $totalStrengthAmount;

        $nonDrawnProbability = 1 - $drawnGameProbability;

        $hostWinProbability = $hostClubStrength * $nonDrawnProbability / $totalStrengthAmount;

        $hostLoseProbability = $nonDrawnProbability - $hostWinProbability;

        return new ResultProbability(
            win: $hostWinProbability,
            drawn:$drawnGameProbability,
            lose: $hostLoseProbability
        );
    }
}