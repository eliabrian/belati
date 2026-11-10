<?php

namespace Database\Factories;

use App\Models\DomainCard;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<DomainCard>
 */
class DomainCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);
        $domains = ['Blade', 'Bone', 'Codex', 'Grace', 'Midnight', 'Sage', 'Splendor', 'Valor', 'Arcana'];

        return [
            'user_id' => null,
            'domain' => fake()->randomElement($domains),
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'level' => fake()->numberBetween(1, 3),
            'type' => fake()->randomElement(['Ability', 'Spell', 'Grimoire']),
            'recall_cost' => fake()->numberBetween(0, 1),
            'description' => fake()->paragraph(),
            'is_srd' => true,
            'is_public' => true,
        ];
    }
}
