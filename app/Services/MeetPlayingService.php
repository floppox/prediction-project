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
        $resultForHostClub = $this->getRandomizedMeetResult(
            $meet->hostClub->notional_strength,
            $meet->guestClub->notional_strength
        );
        $resultForGuestClub = MeetResult::inverse($resultForHostClub);

        $score = $this->getRandomizedScoreForResult($resultForHostClub);

        $meet->setHostClubResult($resultForHostClub->getValue());
        $meet->setHostClubScore($score->getHostClubScore());
        $meet->setHostClubMissedScore($score->getGuestClubScore());
        $meet->setHostClubPoints($resultForHostClub->getPoints());

        $meet->setGuestClubResult($resultForGuestClub->getValue());
        $meet->setGuestClubScore($score->getGuestClubScore());
        $meet->setGuestClubMissedScore($score->getHostClubScore());
        $meet->setGuestClubPoints($resultForGuestClub->getPoints());

        $meet->status = MeetStatus::COMPLETED;

        $meet->save();
    }

    private function getRandomizedMeetResult(
        int $hostClubStrength,
        int $guestClubStrength
    ) : MeetResult
    {
        /** @var ResultProbability $probabilities */
        $probabilities = MeetResultProbabilityCalculator::handle($hostClubStrength, $guestClubStrength);

        $choices = [
            ...array_fill(
                0,
                round(10 * $probabilities->win()),
                MeetResult::WIN
            ),
            ...array_fill(
                0,
                round(10 * $probabilities->drawn()),
                MeetResult::DRAWN
            ),
            ...array_fill(
                0,
                round(10 * $probabilities->lose()),
                MeetResult::LOSE
            ),
        ];

        return new MeetResult(
            $this->faker->randomElement($choices)
        );
    }

    private function getRandomizedScoreForResult(MeetResult $resultForHostClub): MeetScore
    {
        $hostClubScore = rand(0, ceil(self::MAX_POSSIBLE_SCORE / 2));

        $guestClubScore = match($resultForHostClub->getValue()) {
            MeetResult::WIN => rand(0, $hostClubScore - 1),
            MeetResult::DRAWN => $hostClubScore,
            MeetResult::LOSE => rand($hostClubScore + 1, self::MAX_POSSIBLE_SCORE),
        };

        return new MeetScore($hostClubScore, $guestClubScore);
    }
}
