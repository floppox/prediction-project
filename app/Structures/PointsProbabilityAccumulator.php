<?php

namespace App\Structures;

use App\Models\Club;

class PointsProbabilityAccumulator
{
    private float $probabilityProduct = 1;
    private int $pointsSum = 0;

    public function addPoints($pointsToAdd)
    {
        $this->pointsSum += $pointsToAdd;
    }

    public function multiplyProbability($probabilityToMultiply)
    {
        $this->probabilityProduct *= $probabilityToMultiply;
    }
}