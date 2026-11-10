<?php

namespace Database\Factories;

use App\Models\CharacterClass;
use App\Models\Subclass;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Subclass>
 */
class SubclassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->word();

        return [
            'character_class_id' => CharacterClass::factory(),
            'user_id' => null,
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'spellcast_trait' => 'Presence',
            'foundation_feature_name' => 'Foundation Ability',
            'foundation_feature_description' => fake()->sentence(),
            'specialization_feature_name' => 'Specialization Ability',
            'specialization_feature_description' => fake()->sentence(),
            'mastery_feature_name' => 'Mastery Ability',
            'mastery_feature_description' => fake()->sentence(),
            'is_srd' => true,
            'is_public' => true,
        ];
    }
}
