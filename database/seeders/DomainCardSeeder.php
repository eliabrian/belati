<?php

namespace Database\Seeders;

use App\Models\DomainCard;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DomainCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cards = [
            // Blade Domain
            [
                'domain' => 'Blade',
                'name' => 'Get In Here!',
                'level' => 1,
                'type' => 'Ability',
                'recall_cost' => 0,
                'description' => 'Target an adversary within Close range. You pull them into Melee range with you and deal +1d6 physical damage.',
            ],
            [
                'domain' => 'Blade',
                'name' => 'Whirlwind Strike',
                'level' => 1,
                'type' => 'Ability',
                'recall_cost' => 1,
                'description' => 'Spend 1 Hope to swing your melee weapon in a broad arc, striking every adversary within Melee range.',
            ],

            // Bone Domain
            [
                'domain' => 'Bone',
                'name' => 'Deadeye',
                'level' => 1,
                'type' => 'Ability',
                'recall_cost' => 0,
                'description' => 'When making a ranged weapon attack from Far range, add your Instinct trait score to your attack roll.',
            ],
            [
                'domain' => 'Bone',
                'name' => 'Untouchable',
                'level' => 1,
                'type' => 'Ability',
                'recall_cost' => 1,
                'description' => 'Whenever an adversary rolls with Fear and misses you, you may immediately reposition up to Close range as a free action.',
            ],

            // Codex Domain
            [
                'domain' => 'Codex',
                'name' => 'Book of Ava',
                'level' => 1,
                'type' => 'Grimoire',
                'recall_cost' => 0,
                'description' => 'You master the Telekinesis cantrip. Spend 1 Hope to manipulate or levitate heavy objects up to Far range without making a check.',
            ],
            [
                'domain' => 'Codex',
                'name' => 'Arcane Armor',
                'level' => 1,
                'type' => 'Spell',
                'recall_cost' => 1,
                'description' => 'Spend 1 Hope to weave a shimmering lattice of magical shielding, gaining +2 to your Evasion against the next incoming attack.',
            ],

            // Grace Domain
            [
                'domain' => 'Grace',
                'name' => 'Troublemaker',
                'level' => 1,
                'type' => 'Ability',
                'recall_cost' => 0,
                'description' => 'Spend 1 Hope to create an immediate commotion, feint, or distraction that draws enemy attention away from your allies.',
            ],
            [
                'domain' => 'Grace',
                'name' => 'Inspiring Words',
                'level' => 1,
                'type' => 'Ability',
                'recall_cost' => 1,
                'description' => 'Speak courageous words of encouragement to an ally within Far range, allowing them to immediately clear 1 Stress.',
            ],

            // Midnight Domain
            [
                'domain' => 'Midnight',
                'name' => 'Shadow Cloak',
                'level' => 1,
                'type' => 'Spell',
                'recall_cost' => 0,
                'description' => 'Shroud yourself in dim, shifting gloom. Attacks made against you while you are in dim light or shadows have Disadvantage.',
            ],
            [
                'domain' => 'Midnight',
                'name' => 'Backstab',
                'level' => 1,
                'type' => 'Ability',
                'recall_cost' => 1,
                'description' => 'When attacking an adversary with Advantage, add an extra +1d8 precision damage die to your total damage.',
            ],

            // Sage Domain
            [
                'domain' => 'Sage',
                'name' => 'Nourish',
                'level' => 1,
                'type' => 'Spell',
                'recall_cost' => 0,
                'description' => 'Channel revitalizing natural energy into an adjacent companion to heal 1 Hit Point or clear 1 Stress.',
            ],
            [
                'domain' => 'Sage',
                'name' => 'Wild Whispers',
                'level' => 1,
                'type' => 'Ability',
                'recall_cost' => 1,
                'description' => 'Commune with local flora and fauna to learn the direction and nature of the closest hazards or creature trails within Very Far range.',
            ],

            // Splendor Domain
            [
                'domain' => 'Splendor',
                'name' => 'Healing Hands',
                'level' => 1,
                'type' => 'Spell',
                'recall_cost' => 0,
                'description' => 'Touch an injured companion to restore 2 Hit Points and remove the Bleeding or Weakened condition.',
            ],
            [
                'domain' => 'Splendor',
                'name' => 'Radiant Flare',
                'level' => 1,
                'type' => 'Spell',
                'recall_cost' => 1,
                'description' => 'Spend 1 Hope to emit a burst of blinding divine light that inflicts the Vulnerable condition on all adversaries in Close range.',
            ],

            // Valor Domain
            [
                'domain' => 'Valor',
                'name' => 'I Am Your Shield',
                'level' => 1,
                'type' => 'Ability',
                'recall_cost' => 0,
                'description' => 'When an ally in Melee range is attacked, you may choose to intercept the strike, taking the damage onto your own Armor.',
            ],
            [
                'domain' => 'Valor',
                'name' => 'Courageous Roar',
                'level' => 1,
                'type' => 'Ability',
                'recall_cost' => 1,
                'description' => 'Spend 1 Hope to bolster your party with a commanding battle cry, giving all allies in Close range +1 to their next roll.',
            ],

            // Arcana Domain
            [
                'domain' => 'Arcana',
                'name' => 'Mystic Bolt',
                'level' => 1,
                'type' => 'Spell',
                'recall_cost' => 0,
                'description' => 'Hurl a crackling spear of raw magical force at an adversary within Far range, dealing 1d10 arcane magic damage.',
            ],
            [
                'domain' => 'Arcana',
                'name' => 'Blink',
                'level' => 1,
                'type' => 'Spell',
                'recall_cost' => 1,
                'description' => 'Spend 1 Hope to fold space around yourself, instantly teleporting to an unoccupied space within Close range.',
            ],
        ];

        foreach ($cards as $cardData) {
            DomainCard::updateOrCreate(
                ['slug' => Str::slug($cardData['domain'].'-'.$cardData['name'])],
                [
                    'domain' => $cardData['domain'],
                    'name' => $cardData['name'],
                    'level' => $cardData['level'],
                    'type' => $cardData['type'],
                    'recall_cost' => $cardData['recall_cost'],
                    'description' => $cardData['description'],
                    'is_srd' => true,
                    'is_public' => true,
                    'user_id' => null,
                ]
            );
        }
    }
}
