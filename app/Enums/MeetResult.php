<?php

namespace App\Enums;

class MeetResult extends AbstractEnum
{
    const WIN = 'win';
    const DRAWN = 'drawn';
    const LOSE = 'lose';

    public static function inverse(self $meetResult): self
    {
        $inversedValue = match ($meetResult->getValue()) {
            self::WIN => self::LOSE,
            self::LOSE => self::WIN,
            self::DRAWN => self::DRAWN
        };

        return new self($inversedValue);
    }

    static protected function getChoicesArray()
    {
        return [
            self::WIN,
            self::DRAWN,
            self::LOSE
        ];
    }

    public function getPoints(): int
    {
        return match ($this->value) {
            self::WIN => PointsForResult::WIN,
            self::LOSE => PointsForResult::LOSE,
            self::DRAWN => PointsForResult::DRAWN
        };
    }
}