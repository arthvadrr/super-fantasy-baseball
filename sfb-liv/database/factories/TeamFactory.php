<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $city = fake()->city();
        $team_name = fake()->company();
        $team_fullname = $city . " " . $team_name;

        return [
            "user_id" => User::factory(),
            "name" => $team_name,
            "fullname" => $team_fullname,
            "city" => $city,
            "status" => fake()->randomElement(["a", "i"]),
        ];
    }

    public function assignPlayersToTeam(Team $team): void
    {
        $positionCounts = [
            "Pitcher" => 12,
            "Catcher" => 2,
            "First Base" => 1,
            "Second Base" => 1,
            "Third Base" => 1,
            "Shortstop" => 1,
            "Left Field" => 3,
            "Center Field" => 2,
            "Right Field" => 3,
        ];

        $players = Player::factory()->createPlayersForTeam($positionCounts);
        $team->players()->saveMany($players);
    }
}
