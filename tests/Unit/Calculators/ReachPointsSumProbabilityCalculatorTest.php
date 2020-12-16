<?php

namespace Tests\Unit\Calculators;

use Facades\App\Calculators\MeetResultProbabilityCalculator;
use Facades\App\Calculators\ReachPointsSumProbabilityCalculator;
use Tests\TestCase;

/**
 * Class ReachPointsSumProbabilityCalculatorTest.
 *
 * @covers \App\Calculators\ReachPointsSumProbabilityCalculator
 */
class ReachPointsSumProbabilityCalculatorTest extends TestCase
{

    /**
     * @dataProvider dataProveder
     */
    public function testHandle($expectedOutcome, $targetPoints, $strengths): void
    {
        $resultProbabilities = collect($strengths)
            ->map(
                fn($strengthsPair) => MeetResultProbabilityCalculator::handle(...$strengthsPair)
            );

        $result = ReachPointsSumProbabilityCalculator::handle($targetPoints, $resultProbabilities);

//        $this->assertEquals($expectedOutcome, $result);
        $this->assertTrue(
            abs($expectedOutcome - $result) < 0.1
        );
    }

    public function dataProveder()
    {
        yield [
            0.99,
            0.99,
            [[5,0],[5,1],[5,3],[5,7],[5,10]],
        ];
        yield [
            0,
            100,
            [[5,0],[5,1],[5,3],[5,7],[5,10]],
        ];
        yield [
            0.99,
            0,
            [[10,1],[10,1],[10,1],[10,1],[10,1],[10,1],[10,1],[10,1],[10,1],[10,1],],
        ];
        yield [
            0.9,
            2,
            [[5,0],[5,1],[5,3],[5,7],[5,10]],
        ];
        yield [
            0.5,
            3,
            [[1,1],[1,1],],
        ];
    }
}
