<?php

namespace Database\Factories;

use App\Models\CharacterClass;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<CharacterClass>
 */
class CharacterClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->jobTitle();

        return [
            'user_id' => null,
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'primary_domains' => ['Blade', 'Bone'],
            'starting_evasion' => 9,
            'starting_hit_points' => 6,
            'starting_stress' => 6,
            'starting_hope' => 2,
            'base_major_threshold' => 6,
            'base_severe_threshold' => 11,
            'class_feature_name' => 'Battle Momentum',
            'class_feature_description' => fake()->sentence(),
            'hope_feature_name' => 'Inspiring Hope',
            'hope_feature_description' => fake()->sentence(),
            'is_srd' => true,
            'is_public' => true,
        ];
    }
}
