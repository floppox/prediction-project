<?php

namespace App\Calculators;

use Facades\App\Calculators\FloatComparator;

/**
 * Base operations with probability with validation of input parameters and result
 */
class SimpleProbabilityCalculator
{
    public function compatibleSum(float $a, float $b): float
    {
        $this->validate($a, $b);

        $result = $a + $b - $a * $b;

        $this->validate($result);
        return $result;
    }

    public function incompatibleSum(float $a, float $b): float
    {
        $this->validate($a, $b);

        $result = $a + $b;

        $this->validate($result);
        return $result;
    }

    public function multiplication(float $a, float $b): float
    {
        $this->validate($a, $b);

        $result = $a * $b;

        $this->validate($result);
        return $result;
    }

    private function validate(float ...$parameters)
    {
        foreach ($parameters as $a) {
            if (FloatComparator::firstGrater( 0, $a) || FloatComparator::firstGrater( $a, 1))
            {
                throw new \RuntimeException("Invalid Probability $a");
            }
        }
    }
}
