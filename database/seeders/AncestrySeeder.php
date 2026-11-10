<?php

namespace Database\Seeders;

use App\Models\Ancestry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AncestrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ancestries = [
            [
                'name' => 'Clank',
                'description' => 'Sentient beings crafted from metal, gears, and arcane cores, Clanks are living machines with sharp minds and tireless bodies.',
                'features' => [
                    [
                        'name' => 'Clockwork Resilience',
                        'description' => 'Your mechanical body makes you immune to natural poisons and diseases.',
                    ],
                ],
            ],
            [
                'name' => 'Daemon',
                'description' => 'Bearers of horn, tail, and underworld lineage, Daemons channel supernatural willpower and fierce survival instincts.',
                'features' => [
                    [
                        'name' => 'Dread Presence',
                        'description' => 'When you attempt to intimidate or command, roll with Advantage once per rest.',
                    ],
                ],
            ],
            [
                'name' => 'Drakona',
                'description' => 'Descendants of ancient drakes, Drakona boast iridescent scales, sharp claws, and a breath weapon imbued with elemental power.',
                'features' => [
                    [
                        'name' => 'Elemental Breath',
                        'description' => 'Unleash a burst of elemental energy (fire, lightning, frost, or acid) hitting enemies in Close range.',
                    ],
                ],
            ],
            [
                'name' => 'Dwarf',
                'description' => 'Stout, broad-shouldered children of stone and mountain caverns, renowned for their endurance and master craftsmanship.',
                'features' => [
                    [
                        'name' => 'Stoneguard',
                        'description' => 'Add +1 to your starting Armor Score or severe damage threshold.',
                    ],
                ],
            ],
            [
                'name' => 'Elf',
                'description' => 'Graceful and attuned to the natural and celestial currents, Elves possess keen senses and deep mystical intuition.',
                'features' => [
                    [
                        'name' => 'Celestial Trance',
                        'description' => 'Gain 1 extra Hope during short rests under open skies or pristine natural sanctuaries.',
                    ],
                ],
            ],
            [
                'name' => 'Faerie',
                'description' => 'Small, ethereal folk adorned with insectoid or gossamer wings, bringing whimsical magic and effortless flight.',
                'features' => [
                    [
                        'name' => 'Gossamer Wings',
                        'description' => 'You can hover, glide, and fly short distances to bypass ground obstacles.',
                    ],
                ],
            ],
            [
                'name' => 'Fungril',
                'description' => 'Sentient mushroom-folk linked through mycorrhizal networks, capable of sharing impressions and sensing vibrations.',
                'features' => [
                    [
                        'name' => 'Spore Cloud',
                        'description' => 'Emit a cloud of distracting spores to obscure sight or disorient nearby enemies.',
                    ],
                ],
            ],
            [
                'name' => 'Galapa',
                'description' => 'Ancient, patient turtle-folk carrying tough defensive shells on their backs.',
                'features' => [
                    [
                        'name' => 'Hard Shell',
                        'description' => 'Retreat into your shell to increase your Evasion by +2 until your next turn.',
                    ],
                ],
            ],
            [
                'name' => 'Giant',
                'description' => 'Towering mortals infused with the strength of primordial earth, standing head and shoulders above most folk.',
                'features' => [
                    [
                        'name' => 'Mighty Reach',
                        'description' => 'Your melee strikes have extended range and you can wield heavy weapons with one hand.',
                    ],
                ],
            ],
            [
                'name' => 'Goblin',
                'description' => 'Clever, wiry, and remarkably adaptable, Goblins excel in quick escapes and finding creative solutions under pressure.',
                'features' => [
                    [
                        'name' => 'Nimble Escape',
                        'description' => 'Disengage from melee combat without spending extra Action tokens or taking Opportunity Attacks.',
                    ],
                ],
            ],
            [
                'name' => 'Halfling',
                'description' => 'Cheerful and light-footed folk with extraordinary luck that turns the tide when least expected.',
                'features' => [
                    [
                        'name' => 'Fortune Smile',
                        'description' => 'Once per session, reroll your Hope die on any duality check.',
                    ],
                ],
            ],
            [
                'name' => 'Human',
                'description' => 'Ambitious, diverse, and enduring, Humans possess remarkable versatility that allows them to thrive anywhere.',
                'features' => [
                    [
                        'name' => 'Unyielding Grit',
                        'description' => 'Start each session with 1 additional Hope token in your pool.',
                    ],
                ],
            ],
            [
                'name' => 'Katari',
                'description' => 'Sleek, predatory cat-folk with retractable claws, acute hearing, and effortless acrobatic poise.',
                'features' => [
                    [
                        'name' => 'Catlike Reflexes',
                        'description' => 'Never take falling damage from moderate heights and gain +1 to passive Evasion.',
                    ],
                ],
            ],
            [
                'name' => 'Orc',
                'description' => 'Fierce, honorable warriors and protectors who channel fury and brotherhood into unstoppable battlefield momentum.',
                'features' => [
                    [
                        'name' => 'Battle Trance',
                        'description' => 'When your Hit Points fall below half, gain +1d6 bonus damage to your weapon attacks.',
                    ],
                ],
            ],
            [
                'name' => 'Ribbet',
                'description' => 'Amphibious frog-folk adept at leaping great distances and snagging objects with swift prehensile tongues.',
                'features' => [
                    [
                        'name' => 'Spring Leap',
                        'description' => 'Leap up to Far range in a single bounding arc without a running start.',
                    ],
                ],
            ],
            [
                'name' => 'Simian',
                'description' => 'Agile ape- and monkey-folk with grasping prehensile tails and instinctive three-dimensional movement.',
                'features' => [
                    [
                        'name' => 'Prehensile Tail',
                        'description' => 'Your tail functions as a third hand for retrieving items, holding ropes, or drawing secondary weapons.',
                    ],
                ],
            ],
        ];

        foreach ($ancestries as $ancestry) {
            Ancestry::updateOrCreate(
                ['slug' => Str::slug($ancestry['name'])],
                [
                    'name' => $ancestry['name'],
                    'description' => $ancestry['description'],
                    'features' => $ancestry['features'],
                    'is_srd' => true,
                    'is_public' => true,
                    'user_id' => null,
                ]
            );
        }
    }
}
