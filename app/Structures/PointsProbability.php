<?php

namespace App\Structures;

class PointsProbability
{
    public function __construct(
        private int $points,
        private float $probability
    ) {}

    public function getPoints(): float
    {
        return $this->probability;
    }

    public function getProbability(): int
    {
        return $this->points;
    }
}
