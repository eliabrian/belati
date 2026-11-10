<?php

namespace Database\Seeders;

use App\Models\Community;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $communities = [
            [
                'name' => 'Highborne',
                'description' => 'Raised in grand palaces, aristocratic salons, and influential dynasties accustomed to prestige and diplomatic maneuvers.',
                'features' => [
                    [
                        'name' => 'Noble Connections',
                        'description' => 'Gain access to courtly circles, audience with nobility, and starting gold bonuses.',
                    ],
                ],
            ],
            [
                'name' => 'Loreborne',
                'description' => 'Brought up in vast libraries, academy halls, and monastic archives dedicated to uncovering lost knowledge and history.',
                'features' => [
                    [
                        'name' => 'Scholar Memory',
                        'description' => 'Once per rest, automatically recall obscure history, arcane lore, or languages on a successful Knowledge check.',
                    ],
                ],
            ],
            [
                'name' => 'Orderborne',
                'description' => 'Tempered by rigid martial doctrine, religious knighthoods, or sworn civil brotherhoods.',
                'features' => [
                    [
                        'name' => 'Disciplined Mind',
                        'description' => 'Clear 1 Stress whenever you successfully defend an ally or execute a tactical team maneuver.',
                    ],
                ],
            ],
            [
                'name' => 'Ridgeborne',
                'description' => 'Hardened by sheer cliffs, freezing alpine winds, and jagged mountain passes.',
                'features' => [
                    [
                        'name' => 'Surefooted Climber',
                        'description' => 'Climb steep rock faces and traverse icy ledges with natural ease and Advantage.',
                    ],
                ],
            ],
            [
                'name' => 'Seaborne',
                'description' => 'Raised aboard trading galleons, bustling harbors, or wave-swept archipelagos.',
                'features' => [
                    [
                        'name' => 'Waveborn Instincts',
                        'description' => 'Hold your breath twice as long as normal and swim with unimpeded movement speed.',
                    ],
                ],
            ],
            [
                'name' => 'Slyborne',
                'description' => 'Raised on street corners, shadowy alleys, thieves’ guilds, and covert black markets.',
                'features' => [
                    [
                        'name' => 'Street Smarts',
                        'description' => 'Sense ambushes and spot hidden observers in crowded settlements.',
                    ],
                ],
            ],
            [
                'name' => 'Underborne',
                'description' => 'Native to glowing caverns, sprawling subterranean tunnels, and forgotten undercities.',
                'features' => [
                    [
                        'name' => 'Darkvision Attunement',
                        'description' => 'Navigate pitch darkness without relying on torches or magical light sources.',
                    ],
                ],
            ],
            [
                'name' => 'Wanderborne',
                'description' => 'Raised in roaming caravans, nomadic troupes, and endless frontier trails under open stars.',
                'features' => [
                    [
                        'name' => 'Trailblazer',
                        'description' => 'Your party cannot become lost when traversing known wilderness trails.',
                    ],
                ],
            ],
            [
                'name' => 'Wildborne',
                'description' => 'Living deep within primordial forests, untamed savannas, and untracked ancient woods.',
                'features' => [
                    [
                        'name' => 'Beast Whisperer',
                        'description' => 'Communicate basic emotions and intent with wild fauna and forage food with ease.',
                    ],
                ],
            ],
        ];

        foreach ($communities as $community) {
            Community::updateOrCreate(
                ['slug' => Str::slug($community['name'])],
                [
                    'name' => $community['name'],
                    'description' => $community['description'],
                    'features' => $community['features'],
                    'is_srd' => true,
                    'is_public' => true,
                    'user_id' => null,
                ]
            );
        }
    }
}
