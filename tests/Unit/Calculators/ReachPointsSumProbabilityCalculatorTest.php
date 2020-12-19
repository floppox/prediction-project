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
     * @dataProvider dataProvider
     */
    public function testHandle($expectedOutcome, $targetPoints, $strengths): void
    {
        $resultProbabilities = collect($strengths)
            ->map(
                fn($strengthsPair) => MeetResultProbabilityCalculator::handle(...$strengthsPair)
            );

        $result = ReachPointsSumProbabilityCalculator::handle($targetPoints, $resultProbabilities);

        $this->assertTrue(
            abs($expectedOutcome - $result) < 0.01,
            "Got $result when expected $expectedOutcome"
        );
    }

    public function dataProvider()
    {
        yield [
            0.99,
            1,
            [[5,1],[5,1],[5,3],[5,7],[5,10]],
        ];
        yield [
            0.01,
            15,
            [[5,1],[5,1],[5,3],[5,7],[5,10]],
        ];
        yield [
            0.28,
            10,
            [[5,1],[5,1],[5,3],[5,7],[5,10]],
        ];
        yield [
            0,
            100,
            [[5,1],[5,1],[5,3],[5,7],[5,10]],
        ];
        yield [
            0.99,
            0,
            [[10,1],[10,1],[10,1],[10,1],[10,1],[10,1],[10,1],[10,1],[10,1],[10,1],],
        ];
        yield [
            0.99,
            2,
            [[5,1],[5,1],[5,3],[5,7],[5,10]],
        ];
        yield [
            0.4,
            3,
            [[1,1],[1,1],],
        ];
    }
}
