<?php

namespace App\Enums;

class MeetStatus extends AbstractEnum
{
    const FIXTURE = 'fixture';
    const COMPLETED = 'completed';

    static protected function getChoicesArray()
    {
        return [
            self::FIXTURE,
            self::COMPLETED,
        ];
    }
}
