<?php

namespace App\Enums;

class PointsForResult extends AbstractEnum
{
    const WIN = 3;
    const DRAWN = 1;
    const LOSE = 0;

    static protected function getChoicesArray()
    {
        return [
            'WIN' => self::WIN,
            'DRAWN' => self::DRAWN,
            'LOSE' => self::LOSE
        ];
    }
}
