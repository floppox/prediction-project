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
    /**
     * @dataProvider randomDataProvider
     */
    public function testFullProbabilitiesGroup($params): void
    {
        $resultProbability = MeetResultProbabilityCalculator::handle(...$params);

        $this->assertEquals(
            1,
            $resultProbability->win() + $resultProbability->drawn() + $resultProbability->lose(),
        );
    }

    /**
     * @dataProvider expectationsDataProvider
     */
    public function testExpectedResults($expectated, $params): void
    {
        $resultProbability = MeetResultProbabilityCalculator::handle(...$params);

        $this->assertEquals(
            $expectated['win'],
            $resultProbability->win(),
        );
        $this->assertEquals(
            $expectated['drawn'],
            $resultProbability->drawn(),
        );
        $this->assertEquals(
            $expectated['lose'],
             $resultProbability->lose(),
        );
    }

    public function randomDataProvider()
    {
        $yielded = 0;
        while ($yielded < 10) {
            yield [[rand(1,10), rand(1,10)]];
            $yielded++;
        }
    }

    public function expectationsDataProvider()
    {
        yield [['win'=> 2/9, 'drawn' => 2/3, 'lose' => 1/9 ], [1,1]];
        yield [['win'=> 6/49, 'drawn' => 28/49, 'lose' => 15/49 ], [1,5]];
        yield [['win'=> 90/121, 'drawn' => 22/121, 'lose' => 9/121 ], [5,1]];
        yield [['win'=> 2/9, 'drawn' => 2/3, 'lose' => 1/9 ], [5,5]];
    }
}
