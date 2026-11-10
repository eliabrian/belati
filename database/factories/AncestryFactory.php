<?php

namespace Database\Factories;

use App\Models\Ancestry;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Ancestry>
 */
class AncestryFactory extends Factory
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
            'user_id' => null,
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'features' => [
                [
                    'name' => 'Ancestral Feature',
                    'description' => fake()->sentence(),
                ],
            ],
            'is_srd' => true,
            'is_public' => true,
        ];
    }
}
