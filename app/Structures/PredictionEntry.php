<?php

namespace App\Structures;

class PredictionEntry
{
    public function __construct(
        private int $clubId,
        private string $clubName,
        private int $position,
        private ?float $championshipProbability = null
    ) {}

    public function toArray(): array
    {
        return [
            'club_id' => $this->clubId,
            'club_name' => $this->clubName,
            'current_position' => $this->position,
            'championship_probability' => $this->championshipProbability
        ];
    }

    public function fromArray(array $values): self
    {
        $this->clubId = $values['club_id'];
        $this->clubName = $values['club_name'];
        $this->position = $values['position'];
        $this->championshipProbability = $values['championship_probability'];

        return $this;
    }
}