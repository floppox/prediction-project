<?php

namespace App\Calculators;

class SimpleProbabilityCalculator
{
    public function compatibleSum(float $a, float $b)
    {
        $this->validate($a, $b);

        $result = $a + $b - $a * $b;

        $this->validate($result);
        return $result;
    }

    private function validate(float ...$parmeters)
    {
        foreach ($parmeters as $a) {
            if ($a < 0 || $a > 1) {
                throw new \RuntimeException('Invalid Probability');
            }
        }
    }
}
