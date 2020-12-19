<?php

namespace App\Structures;

class ResultProbability
{
    public function __construct(
        private float $win,
        private float $drawn,
        private float $lose,
    ) {
        if (0 == $this->win || 0 == $this->drawn || 0 == $this->lose) {
            throw new \RuntimeException('Zero value is not allowed in ResultProbability context');
        }
    }

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