<?php

namespace App\Structures;

class PointsProbability
{
    public function __construct(
        private int $points,
        private float $probability
    ) {}

    public function getPoints(): int
    {
        return $this->points;
    }

    public function getProbability(): float
    {
        return $this->probability;
    }
}
