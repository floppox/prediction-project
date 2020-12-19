<?php

namespace App\Calculators;

class FloatComparator
{
    const EPSILON = 1 / 1000000000;

    public function eq(float $a, float $b): bool
    {
        return abs($a - $b ) < self::EPSILON;
    }

    public function firstGrater(float $a, float $b): bool
    {
        return ($a - $b) > self::EPSILON;
    }

    public function firstGraterOrEqual(float $a, float $b): bool
    {
        return ($a - $b) > (- self::EPSILON);
    }

}