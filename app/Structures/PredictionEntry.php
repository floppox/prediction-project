<?php

namespace App\Structures;

class PredictionEntry implements StructureInterface
{
    private ?float $championshipProbability = null;
    private string $clubName;
    private int $clubId;

    public function toArray(): array
    {
        return [
            'club_id' => $this->clubId,
            'club_name' => $this->clubName,
            'championship_probability' => $this->championshipProbability
        ];
    }

    public function fromArray(array $values): StructureInterface
    {
        $this->clubId = $values['club_id'];
        $this->clubName = $values['club_name'];
        $this->championshipProbability = $values['championship_probability'];

        return $this;
    }
}