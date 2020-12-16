<?php

namespace Tests\Unit\Calculators;

use Facades\App\Calculators\MeetResultProbabilityCalculator;
use Tests\TestCase;

/**
 * Class MeetResultProbabilityCalculatorTest.
 *
 * @covers \App\Calculators\MeetResultProbabilityCalculator
 */
class MeetResultProbabilityCalculatorTest extends TestCase
{
    public function testHandle(): void
    {
        $resultProbability = MeetResultProbabilityCalculator::handle(1, 1);

        $this->assertEquals(
            1,
            $resultProbability->win() + $resultProbability->drawn() + $resultProbability->lose(),
        );
    }
}
