<?php

namespace App\Calculators;

use App\Structures\ResultProbability;

class MeetResultProbabilityCalculator
{
    const HOME_MEET_FACTOR = 2;
    const MAX_POOSIBLE_DRAWN_PROVBILITY = 0.7;
    const MIN_POSSIBLE_STRENGTH = 0.1;

    public function handle(
        float|int $hostClubStrength,
        float|int $guestClubStrength
    ): ResultProbability
    {
        $hostClubStrength = self::HOME_MEET_FACTOR * max($hostClubStrength, self::MIN_POSSIBLE_STRENGTH) ;
        $guestClubStrength = max($guestClubStrength, self::MIN_POSSIBLE_STRENGTH);

        $totalStrengthAmount = $hostClubStrength + $guestClubStrength;

        $drawnGameProbability = min(
            abs($hostClubStrength - $guestClubStrength) / $totalStrengthAmount,
            self::MAX_POOSIBLE_DRAWN_PROVBILITY
        );

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