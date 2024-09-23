<?php

namespace Database\Factories;
use App\Models\Player;

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

        $isPitcher = fake()->boolean(20);
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        $fullName = $firstName . ' ' . $lastName;
        $position = $isPitcher ? 'Pitcher' : fake()->randomElement($positions);
        $pitches = $isPitcher
            ? json_encode(
                fake()->randomElements(
                    $all_pitches,
                    fake()->numberBetween(1, 3)
                )
            )
            : null;

        return [
            'full_name' => $fullName,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'age' => fake()->numberBetween(18, 52),
            'position' => $position,
            'rating_arm' => fake()->numberBetween(0, 100),
            'rating_speed' => fake()->numberBetween(0, 100),
            'rating_hitting' => fake()->numberBetween(0, 100),
            'rating_fielding' => fake()->numberBetween(0, 100),
            'pitches' => $pitches,
            'rating_pitching' => $isPitcher
                ? fake()->numberBetween(0, 100)
                : null,
        ];
    }

    /**
     * Create players based on the positionCounts array.
     *
     * @param array<string, int> $positionCounts
     * @return \Illuminate\Support\Collection
     */
    public function createPlayersForTeam(array $positionCounts)
    {
        $players = collect();

        foreach ($positionCounts as $position => $count) {
            for ($i = 0; $i < $count; $i++) {
                $players->push($this->createPlayerForPosition($position));
            }
        }

        return $players;
    }

    /**
     * Create a single player for the given position.
     *
     * @param string $position
     * @return \App\Models\Player
     */
    private function createPlayerForPosition(string $position)
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

        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        $fullName = $firstName . ' ' . $lastName;

        $isPitcher = $position === 'Pitcher';
        $pitches = $isPitcher
            ? fake()->randomElements($all_pitches, fake()->numberBetween(1, 3))
            : null;

        return Player::create([
            'full_name' => $fullName,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'age' => fake()->numberBetween(18, 45),
            'position' => $position,
            'rating_arm' => fake()->numberBetween(0, 100),
            'rating_speed' => fake()->numberBetween(0, 100),
            'rating_hitting' => fake()->numberBetween(0, 100),
            'rating_fielding' => fake()->numberBetween(0, 100),
            'pitches' => $pitches,
            'rating_pitching' => $isPitcher
                ? fake()->numberBetween(0, 100)
                : null,
        ]);
    }
}
