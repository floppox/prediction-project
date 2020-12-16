<?php

namespace App\Enums;

use \RuntimeException;

abstract class AbstractEnum
{
    protected string|int|float $value;

    public function __construct(string $value)
    {
        if (in_array($value, static::getChoicesArray())) {
            $this->value = $value;
        }

        else throw new RuntimeException('Wrong Enum Value');
    }

    public function getValue()
    {
        return $this->value;
    }
}