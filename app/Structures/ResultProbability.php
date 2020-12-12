<?php

namespace App\Structures;

class ResultProbability
{
    public function __construct(
        private float $win,
        private float $drawn,
        private float $lose,
    ) {}

    public function win() {
        return $this->win;
    }
    public function drawn() {
        return $this->drawn;
    }
    public function lose() {
        return $this->lose;
    }
}