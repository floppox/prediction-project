<?php

namespace App\Calculators;

class ScheduleCalculator
{
    public function handle($clubsCount)
    {
        $oneClubSkipsEachTour = false;

        if ($clubsCount % 2) {
            $clubsCount ++;
            $oneClubSkipsEachTour = true;
        }

        $halfToursCount = $clubsCount - 1;
        $lastClubIndex = $clubsCount - 1;
        $meetsPerTour = floor($clubsCount / 2);

        $schedule = [];

        for ($tourIndex = 0; $tourIndex < $halfToursCount; $tourIndex++) {
            for ($meetIndex = 0; $meetIndex < $meetsPerTour; $meetIndex++) {
                $homeClubIndex = ($tourIndex + $meetIndex) % $halfToursCount;
                $guestClubIndex = 0 === $meetIndex
                    ? ($oneClubSkipsEachTour ? -1 : $lastClubIndex)
                    : ($lastClubIndex - $meetIndex + $tourIndex) % $halfToursCount;

                $schedule[$tourIndex][] = [$homeClubIndex, $guestClubIndex];
                $schedule[$tourIndex + $halfToursCount][] = [$guestClubIndex, $homeClubIndex];
            }
        }

        return $schedule;
    }
}