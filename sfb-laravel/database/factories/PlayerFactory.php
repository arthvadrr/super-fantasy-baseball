<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $all_pitches = [
            'Fastball',
            'Curveball',
            'Slider',
            'Changeup',
            'Cutter',
            'Sinker',
            'Screwball',
        ];

        $positions = [
            'Catcher',
            'First Base',
            'Second Base',
            'Third Base',
            'Shortstop',
            'Left field',
            'Center field',
            'Right Field',
        ];

        $isPitcher = $this->faker->boolean(20);
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        $fullName = $firstName . ' ' . $lastName;
        $position = $isPitcher ? 'Pitcher' : fake()->randomElement($positions);
        $pitches = $isPitcher
            ? $this->faker->randomElements(
                $all_pitches,
                $this->faker->numberBetween(1, 3)
            )
            : null;

        return [
            'full_name' => $fullName,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'age' => fake()->numberBetween(18, 52),
            'position' => $position,
            'rating_arm' => $this->faker->numberBetween(0, 100),
            'rating_speed' => $this->faker->numberBetween(0, 100),
            'rating_hitting' => $this->faker->numberBetween(0, 100),
            'rating_fielding' => $this->faker->numberBetween(0, 100),
            'pitches' => $pitches,
            'rating_pitching' => $isPitcher
                ? $this->faker->numberBetween(0, 100)
                : null,
        ];
    }
}
