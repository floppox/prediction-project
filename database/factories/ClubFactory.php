<?php

namespace Database\Factories;

use App\Models\Club;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClubFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Club::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'notional_strength' => $this->faker->randomNumber(0),
        ];
    }
}
