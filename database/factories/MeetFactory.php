<?php

namespace Database\Factories;

use App\Models\Meet;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tour_number' =>$this->faker->numberBetween(1, 10),
            'city' => $this->faker->city,
            'venue' => $this->faker->sentence(1) . ' Arena',
        ];
    }
}
