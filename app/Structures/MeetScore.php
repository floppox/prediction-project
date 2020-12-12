<?php

namespace App\Structures;

class MeetScore
{
    public function __construct(
        private int $hostClubScore = 0,
        private int $guestClubScore = 0,
    ) {}

    public function toArray(): array
    {
        return [
            $this->hostClubScore,
            $this->guestClubScore
        ];
    }

    public function fromArray(array $values): self
    {
        $this->hostClubScore = $values[0];
        $this->guestClubScore = $values[1];

        return $this;
    }

    public function incrementHostClubScore(): self
    {
        $this->hostClubScore++;

        return $this;
    }

    public function incrementGuestClubScore(): self
    {
        $this->guestClubScore++;

        return $this;
    }

    public function getHostClubScore(): int
    {
        return $this->hostClubScore;
    }

    public function getGuestClubScore(): int
    {
        return $this->guestClubScore;
    }
}