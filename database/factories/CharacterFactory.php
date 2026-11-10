<?php

namespace Database\Factories;

use App\Models\Ancestry;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Community;
use App\Models\Subclass;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Character>
 */
class CharacterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'character_class_id' => CharacterClass::factory(),
            'subclass_id' => Subclass::factory(),
            'ancestry_id' => Ancestry::factory(),
            'community_id' => Community::factory(),
            'name' => fake()->name(),
            'pronouns' => fake()->randomElement(['they/them', 'she/her', 'he/him', 'any']),
            'level' => 1,
            'agility' => 1,
            'strength' => 2,
            'finesse' => 0,
            'instinct' => 1,
            'presence' => 0,
            'knowledge' => -1,
            'hit_points_current' => 6,
            'hit_points_max' => 6,
            'stress_current' => 0,
            'stress_max' => 6,
            'hope_current' => 2,
            'hope_max' => 6,
            'armor_score' => 2,
            'armor_slots_current' => 0,
            'armor_slots_max' => 6,
            'evasion' => 9,
            'major_threshold' => 6,
            'severe_threshold' => 11,
            'gold' => fake()->numberBetween(10, 50),
            'background' => fake()->paragraph(),
            'notes' => fake()->sentence(),
            'is_public' => false,
        ];
    }
}
