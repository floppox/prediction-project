<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\TournamentTableEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

class TournamentTableEntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TournamentTableEntry::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'played' => $this->faker->numberBetween(0, 127),
            'won' => $this->faker->numberBetween(0, 127),
            'drawn' => $this->faker->numberBetween(0, 127),
            'lost' => $this->faker->numberBetween(0, 127),
            'gf' => $this->faker->numberBetween(0, 127),
            'ga' => $this->faker->numberBetween(0, 127),
            'gd' => $this->faker->numberBetween(0, 127),
            'points' => $this->faker->numberBetween(0, 127),
            'club_id' => \App\Models\Club::factory(),
        ];
    }
}
