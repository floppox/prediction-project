<?php

namespace App\Services;

use App\Models\Meet;

class TourManagementService
{
    public function __construct(
        protected MeetPlayingService $meetPlayingService
    ) {}

    public function getTour(int $tourNumber)
    {
        return Meet::where('tour_number', $tourNumber)
            ->with('clubs')
            ->get();
    }

    public function listTours()
    {
        return Meet::with('clubs')
            ->get()
            ->groupBy('tour_number');
    }

    public function getLastPlayedTour()
    {
        $lastTourNumber = Meet::whereIn('status', ['completed'])
            ->orderByDesc('tour_number')
            ->value('tour_number');

        return $this->getTour($lastTourNumber);
    }

    public function playNextTour()
    {
        $nextTourNumber = Meet::whereIn('status', ['fixture'])
            ->orderBy('tour_number')
            ->value('tour_number');

        $meets = $this->getTour($nextTourNumber);

        $meets->each(fn($meet) => $this->meetPlayingService->playMeet($meet));

        return $meets;
    }
}
