<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'floor' => $this->faker->numberBetween(1, 10),
            'number' => $this->faker->unique()->numberBetween(101, 999),
            'name' => $this->faker->word,
            'is_available' => $this->faker->boolean,
            'hotel_id' => function () {
                // Assuming you have Hotel models seeded, you can assign a hotel_id from existing hotels.
                return \App\Models\Hotel::inRandomOrder()->first()->id;
            },
        ];
    }

}
