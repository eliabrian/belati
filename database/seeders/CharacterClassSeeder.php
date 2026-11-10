<?php

namespace Database\Seeders;

use App\Models\CharacterClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CharacterClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            [
                'name' => 'Bard',
                'description' => 'Charismatic performers and spell-weavers who inspire allies, disrupt foes, and alter destiny through wit, rhythm, and arcana.',
                'primary_domains' => ['Grace', 'Codex'],
                'starting_evasion' => 9,
                'starting_hit_points' => 6,
                'starting_stress' => 6,
                'starting_hope' => 2,
                'base_major_threshold' => 5,
                'base_severe_threshold' => 10,
                'class_feature_name' => 'Rally the Party',
                'class_feature_description' => 'Spend 1 Hope to give an ally within Far range a Rally Die (d6) to add to their next roll.',
                'hope_feature_name' => 'Encore',
                'hope_feature_description' => 'When an ally rolls with Hope, you may also gain 1 Hope if you are within Close range.',
            ],
            [
                'name' => 'Druid',
                'description' => 'Primal shamans and shapeshifters who channel the raw elements and transform into ferocious wild beasts.',
                'primary_domains' => ['Sage', 'Arcana'],
                'starting_evasion' => 9,
                'starting_hit_points' => 6,
                'starting_stress' => 6,
                'starting_hope' => 2,
                'base_major_threshold' => 6,
                'base_severe_threshold' => 11,
                'class_feature_name' => 'Beastform',
                'class_feature_description' => 'Spend 1 Hope to transform into an animal shape (scout, predator, or guardian), gaining enhanced traits and natural weapons.',
                'hope_feature_name' => 'Nature’s Mending',
                'hope_feature_description' => 'When you roll with Hope, clear 1 Stress or heal 1 Hit Point on yourself or an adjacent companion.',
            ],
            [
                'name' => 'Guardian',
                'description' => 'Unshakable bastions who stand at the vanguard, shielding allies and intercepting deadly enemy strikes.',
                'primary_domains' => ['Valor', 'Blade'],
                'starting_evasion' => 8,
                'starting_hit_points' => 6,
                'starting_stress' => 6,
                'starting_hope' => 2,
                'base_major_threshold' => 7,
                'base_severe_threshold' => 13,
                'class_feature_name' => 'Unstoppable Shield',
                'class_feature_description' => 'Intercept an attack targeted at an ally within Melee range, taking the damage onto your own Armor.',
                'hope_feature_name' => 'Stand Firm',
                'hope_feature_description' => 'Spend 1 Hope to ignore the next instance of forced movement or knockdown.',
            ],
            [
                'name' => 'Ranger',
                'description' => 'Deadly scouts and survivalists who hunt designated quarry with bows, blades, and animal companionship.',
                'primary_domains' => ['Bone', 'Sage'],
                'starting_evasion' => 10,
                'starting_hit_points' => 6,
                'starting_stress' => 6,
                'starting_hope' => 2,
                'base_major_threshold' => 6,
                'base_severe_threshold' => 11,
                'class_feature_name' => 'Ranger’s Quarry',
                'class_feature_description' => 'Designate an enemy as your Quarry to gain +1d6 bonus damage and track their movements effortlessly.',
                'hope_feature_name' => 'Focus Aim',
                'hope_feature_description' => 'Spend 1 Hope to reroll any ranged weapon attack die.',
            ],
            [
                'name' => 'Rogue',
                'description' => 'Shadow-stalkers, infiltrators, and opportunists who strike with lethal precision from blind spots.',
                'primary_domains' => ['Midnight', 'Grace'],
                'starting_evasion' => 11,
                'starting_hit_points' => 6,
                'starting_stress' => 6,
                'starting_hope' => 2,
                'base_major_threshold' => 5,
                'base_severe_threshold' => 9,
                'class_feature_name' => 'Sneak Attack',
                'class_feature_description' => 'When striking an enemy while hidden or while they are engaged with an ally, deal an additional +1d8 precision damage.',
                'hope_feature_name' => 'Vanish in Shadows',
                'hope_feature_description' => 'Spend 1 Hope after attacking to immediately become Hidden again.',
            ],
            [
                'name' => 'Seraph',
                'description' => 'Divine emissaries blessed with holy authority, luminous flight, and restorative healing magic.',
                'primary_domains' => ['Splendor', 'Valor'],
                'starting_evasion' => 8,
                'starting_hit_points' => 6,
                'starting_stress' => 6,
                'starting_hope' => 2,
                'base_major_threshold' => 6,
                'base_severe_threshold' => 11,
                'class_feature_name' => 'Luminous Prayer',
                'class_feature_description' => 'Spend 1 Hope to heal 2 Hit Points on an ally or blast undead/fiends with radiant damage.',
                'hope_feature_name' => 'Holy Wings',
                'hope_feature_description' => 'Manifest spectral radiant wings to leap safely across battlefield hazards.',
            ],
            [
                'name' => 'Sorcerer',
                'description' => 'Volatile spellcasters whose innate bloodline commands unpredictable arcane chaos.',
                'primary_domains' => ['Arcana', 'Midnight'],
                'starting_evasion' => 9,
                'starting_hit_points' => 6,
                'starting_stress' => 6,
                'starting_hope' => 2,
                'base_major_threshold' => 5,
                'base_severe_threshold' => 9,
                'class_feature_name' => 'Arcane Surge',
                'class_feature_description' => 'Channel latent magical volatility to add extra damage dice or increase spell target range at the cost of Stress.',
                'hope_feature_name' => 'Sorcerous Spark',
                'hope_feature_description' => 'Spend 1 Hope to regain an expended spell slot or convert Fear rolled into raw magic.',
            ],
            [
                'name' => 'Warrior',
                'description' => 'Masters of physical martial combat, lethal weaponry, and unrelenting offensive momentum.',
                'primary_domains' => ['Blade', 'Bone'],
                'starting_evasion' => 9,
                'starting_hit_points' => 6,
                'starting_stress' => 6,
                'starting_hope' => 2,
                'base_major_threshold' => 7,
                'base_severe_threshold' => 13,
                'class_feature_name' => 'Combat Momentum',
                'class_feature_description' => 'Whenever you defeat an adversary or score a Critical Success, make a free follow-up strike against another foe in Melee.',
                'hope_feature_name' => 'Battle Cry',
                'hope_feature_description' => 'Spend 1 Hope to force all adversaries in Close range to make their next roll against you with Disadvantage.',
            ],
            [
                'name' => 'Wizard',
                'description' => 'Scholarly masters of ancient grimoires, tactical battlefield control, and intricate incantations.',
                'primary_domains' => ['Codex', 'Splendor'],
                'starting_evasion' => 8,
                'starting_hit_points' => 6,
                'starting_stress' => 6,
                'starting_hope' => 2,
                'base_major_threshold' => 5,
                'base_severe_threshold' => 9,
                'class_feature_name' => 'Spell Mastery',
                'class_feature_description' => 'Prepare signature spells from your grimoire and cast them without exhausting your primary action.',
                'hope_feature_name' => 'Arcane Recall',
                'hope_feature_description' => 'Spend 1 Hope to swap any domain card in your active loadout with a card from your vault.',
            ],
        ];

        foreach ($classes as $classData) {
            CharacterClass::updateOrCreate(
                ['slug' => Str::slug($classData['name'])],
                [
                    'name' => $classData['name'],
                    'description' => $classData['description'],
                    'primary_domains' => $classData['primary_domains'],
                    'starting_evasion' => $classData['starting_evasion'],
                    'starting_hit_points' => $classData['starting_hit_points'],
                    'starting_stress' => $classData['starting_stress'],
                    'starting_hope' => $classData['starting_hope'],
                    'base_major_threshold' => $classData['base_major_threshold'],
                    'base_severe_threshold' => $classData['base_severe_threshold'],
                    'class_feature_name' => $classData['class_feature_name'],
                    'class_feature_description' => $classData['class_feature_description'],
                    'hope_feature_name' => $classData['hope_feature_name'],
                    'hope_feature_description' => $classData['hope_feature_description'],
                    'is_srd' => true,
                    'is_public' => true,
                    'user_id' => null,
                ]
            );
        }
    }
}
