<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AncestrySeeder::class,
            CommunitySeeder::class,
            CharacterClassSeeder::class,
            SubclassSeeder::class,
            DomainCardSeeder::class,
        ]);

        if (app()->environment('local')) {
            User::firstOrCreate(
                ['username' => 'DaggerHero'],
                [
                    'email' => 'hero@example.com',
                    'password' => bcrypt('password'),
                ]
            );
        }
    }
}
