<?php

namespace App\Services;

use App\Structures\ResultProbability;
use Facades\App\Calculators\MeetResultProbabilityCalculator;
use App\Enums\MeetResult;
use App\Enums\MeetStatus;
use App\Models\Meet;
use App\Structures\MeetScore;
use Faker\Generator as Faker;

class MeetPlayingService
{
    const MAX_POSSIBLE_SCORE = 9;

    public function __construct(
        protected Faker $faker
    ){}

    public function playMeet(Meet $meet)
    {
        $resultForHostClub = $this->getRandomizeMeetResult(
            $meet->hostClub->notional_strength,
            $meet->guestClub->notional_strength
        );

        $score = $this->getScoreForResult($resultForHostClub);

        $meet->setHostClubResult($resultForHostClub->getValue());
        $meet->setHostClubScore($score->getHostClubScore());
        $meet->setHostClubMissedScore($score->getGuestClubScore());

        $meet->setGuestClubResult(MeetResult::inverse($resultForHostClub)->getValue());
        $meet->setGuestClubScore($score->getGuestClubScore());
        $meet->setGuestClubMissedScore($score->getHostClubScore());

        $meet->status = MeetStatus::COMPLETED;

        $meet->save();
    }

    private function getRandomizeMeetResult(
        int $hostClubStrength,
        int $guestClubStrength
    ) : MeetResult
    {
        /** @var ResultProbability $probabilities */
        $probabilities = MeetResultProbabilityCalculator::handle($hostClubStrength, $guestClubStrength);

        $choices = [
            ...array_fill(
                0,
                10 * round($probabilities->win()),
                MeetResult::WIN
            ),
            ...array_fill(
                0,
                10 * round($probabilities->drawn()),
                MeetResult::DRAWN
            ),
            ...array_fill(
                0,
                10 * round($probabilities->lose()),
                MeetResult::LOSE
            ),
        ];

        return new MeetResult(
            $this->faker->randomElement($choices)
        );
    }

    private function getScoreForResult(MeetResult $resultForHostClub): MeetScore
    {
        $hostClubScore = rand(0, ceil(self::MAX_POSSIBLE_SCORE / 2));

        $guestClubScore = match($resultForHostClub->getValue()) {
            MeetResult::WIN => rand(0, $resultForHostClub->getValue()),
            MeetResult::DRAWN => $resultForHostClub->getValue(),
            MeetResult::LOSE => rand($resultForHostClub->getValue(), self::MAX_POSSIBLE_SCORE),
        };

        return app(MeetScore::class)->fromArray([
            $hostClubScore,
            $guestClubScore,
        ]);
    }
}
