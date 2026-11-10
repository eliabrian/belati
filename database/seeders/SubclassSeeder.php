<?php

namespace Database\Seeders;

use App\Models\CharacterClass;
use App\Models\Subclass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubclassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subclasses = [
            // Warrior Subclasses
            [
                'class_slug' => 'warrior',
                'name' => 'Juggernaut',
                'description' => 'A walking fortress who turns their immense momentum into catastrophic blows.',
                'spellcast_trait' => 'Strength',
                'foundation_feature_name' => 'Heavy Impact',
                'foundation_feature_description' => 'When moving into melee range before attacking, add your Strength score directly to your damage total.',
                'specialization_feature_name' => 'Unstoppable Charge',
                'specialization_feature_description' => 'Crash through obstacles and knock back adversaries within Close range.',
                'mastery_feature_name' => 'Colossus Form',
                'mastery_feature_description' => 'Double your damage thresholds and become immune to knockdown and restraint.',
            ],
            [
                'class_slug' => 'warrior',
                'name' => 'Slayer',
                'description' => 'A master of lethal, relentless weapon strikes specialized in cutting down high-threat targets.',
                'spellcast_trait' => 'Agility',
                'foundation_feature_name' => 'Lethal Precision',
                'foundation_feature_description' => 'Score Critical Successes on duality rolls with matching doubles or any roll where your Hope die shows 11 or 12.',
                'specialization_feature_name' => 'Whirlwind Strike',
                'specialization_feature_description' => 'Strike all enemies within Melee range with a single sweeping attack.',
                'mastery_feature_name' => 'Executioner’s Edge',
                'mastery_feature_description' => 'Immediately execute any adversary with Hit Points below their Severe damage threshold.',
            ],

            // Rogue Subclasses
            [
                'class_slug' => 'rogue',
                'name' => 'Nightwalker',
                'description' => 'A ghost in the dark who slips between shadows, bypassing locks, barriers, and guards.',
                'spellcast_trait' => 'Instinct',
                'foundation_feature_name' => 'Shadow Step',
                'foundation_feature_description' => 'Teleport between shadows up to Close range as a free movement.',
                'specialization_feature_name' => 'Gloom Veil',
                'specialization_feature_description' => 'Shroud yourself in magical darkness that blinds attackers.',
                'mastery_feature_name' => 'Avatar of the Void',
                'mastery_feature_description' => 'Become incorporeal, walking through solid walls and ignoring physical damage.',
            ],
            [
                'class_slug' => 'rogue',
                'name' => 'Syndicate',
                'description' => 'A charismatic schemer who leverages underworld connections, cunning deceits, and cutthroat tactics.',
                'spellcast_trait' => 'Presence',
                'foundation_feature_name' => 'Kingpin’s Call',
                'foundation_feature_description' => 'Call in favors or underworld agents to acquire black market goods or stage a diversion.',
                'specialization_feature_name' => 'Dirty Fighting',
                'specialization_feature_description' => 'Pocket sand, cheap shots, or hidden blades that impose Vulnerable or Blinded on enemies.',
                'mastery_feature_name' => 'Coup de Grâce',
                'mastery_feature_description' => 'Exploit any status condition on a target to deal triple Sneak Attack damage.',
            ],

            // Bard Subclasses
            [
                'class_slug' => 'bard',
                'name' => 'Troubadour',
                'description' => 'An enchanting storyteller whose lyrical music weaves powerful enchantments and bolsters party morale.',
                'spellcast_trait' => 'Presence',
                'foundation_feature_name' => 'Inspiring Ballad',
                'foundation_feature_description' => 'While singing, all allies in Far range gain +1 to their evasion and clear 1 Stress on a Critical roll.',
                'specialization_feature_name' => 'Captivating Aria',
                'specialization_feature_description' => 'Enthrall enemies within Close range, halting their attacks until harmed.',
                'mastery_feature_name' => 'Song of Legends',
                'mastery_feature_description' => 'Restore Hit Points to all party members and grant immediate free Action tokens.',
            ],
            [
                'class_slug' => 'bard',
                'name' => 'Wordsmith',
                'description' => 'A sharp-tongued orator who cuts foes with devastating insults and alters reality through verse.',
                'spellcast_trait' => 'Knowledge',
                'foundation_feature_name' => 'Cutting Words',
                'foundation_feature_description' => 'Use a reaction to subtract your Presence modifier from an incoming enemy attack roll.',
                'specialization_feature_name' => 'Silver Tongue',
                'specialization_feature_description' => 'Convince an enemy to doubt their orders or turn temporarily against their commander.',
                'mastery_feature_name' => 'Dictate Destiny',
                'mastery_feature_description' => 'Rewrite the outcome of any roll made by any creature within Far range.',
            ],

            // Druid Subclasses
            [
                'class_slug' => 'druid',
                'name' => 'Warden of the Elements',
                'description' => 'Channels the raw wrath of thunder, fire, earth, and howling tempests.',
                'spellcast_trait' => 'Instinct',
                'foundation_feature_name' => 'Elemental Infusion',
                'foundation_feature_description' => 'Coat your weapons or natural beastform claws in elemental fire or frost for +1d6 extra damage.',
                'specialization_feature_name' => 'Storm Calling',
                'specialization_feature_description' => 'Summon gale-force winds and lightning strikes across the battlefield.',
                'mastery_feature_name' => 'Wrath of the Earth',
                'mastery_feature_description' => 'Trigger a seismic tremor that knocks down all enemies and shatters stone fortifications.',
            ],
            [
                'class_slug' => 'druid',
                'name' => 'Warden of Renewal',
                'description' => 'Attuned to spring growth, fertile soil, and restorative natural remedies.',
                'spellcast_trait' => 'Instinct',
                'foundation_feature_name' => 'Verdant Touch',
                'foundation_feature_description' => 'Touch an ally to purge poisons, cleanse diseases, and heal 2 Hit Points.',
                'specialization_feature_name' => 'Grasping Vines',
                'specialization_feature_description' => 'Sprout tangled roots that restrain adversaries in Close range.',
                'mastery_feature_name' => 'Bloom of Rebirth',
                'mastery_feature_description' => 'Revive a fallen companion from death or restore the party to full health during battle.',
            ],

            // Guardian Subclasses
            [
                'class_slug' => 'guardian',
                'name' => 'Stalwart',
                'description' => 'The premier defensive protector who holds chokepoints and absorbs unimaginable damage.',
                'spellcast_trait' => 'Strength',
                'foundation_feature_name' => 'Shield Wall',
                'foundation_feature_description' => 'Lock shields to provide total cover to all allies standing behind you.',
                'specialization_feature_name' => 'Iron Fortress',
                'specialization_feature_description' => 'Spend 1 Armor token to negate all damage from a single attack.',
                'mastery_feature_name' => 'Indomitable Wall',
                'mastery_feature_description' => 'Cannot be dropped below 1 Hit Point for the remainder of the encounter.',
            ],
            [
                'class_slug' => 'guardian',
                'name' => 'Vengeance',
                'description' => 'A frontline punisher who turns the enemy’s own aggressive strikes back upon them.',
                'spellcast_trait' => 'Strength',
                'foundation_feature_name' => 'Retribution Strike',
                'foundation_feature_description' => 'Whenever an enemy hits an ally in Melee range, immediately counter-attack that enemy for full damage.',
                'specialization_feature_name' => 'Vengeful Brand',
                'specialization_feature_description' => 'Brand a target so that every point of damage they deal is dealt back to them.',
                'mastery_feature_name' => 'Wrath Unleashed',
                'mastery_feature_description' => 'Unleash stored kinetic damage as a radiant explosion hitting all surrounding foes.',
            ],

            // Ranger Subclasses
            [
                'class_slug' => 'ranger',
                'name' => 'Wayfinder',
                'description' => 'An expert tracker and sniper who spots weaknesses and pathfinds through deadly territory.',
                'spellcast_trait' => 'Instinct',
                'foundation_feature_name' => 'Eagle Eye',
                'foundation_feature_description' => 'Ignore cover penalties and increase all ranged weapon maximum ranges by one bracket.',
                'specialization_feature_name' => 'Trick Shot',
                'specialization_feature_description' => 'Pin enemies to walls or ricochet arrows to strike multiple targets.',
                'mastery_feature_name' => 'Unerring Strike',
                'mastery_feature_description' => 'Your ranged attacks never miss and always pierce through armor.',
            ],
            [
                'class_slug' => 'ranger',
                'name' => 'Beastmaster',
                'description' => 'Bonded with a loyal animal companion (wolf, bear, hawk, or panther) who fights alongside them.',
                'spellcast_trait' => 'Instinct',
                'foundation_feature_name' => 'Bonded Companion',
                'foundation_feature_description' => 'Your animal companion acts in sync with you, flanking enemies and harassing targets.',
                'specialization_feature_name' => 'Pack Tactics',
                'specialization_feature_description' => 'Both you and your beast gain Advantage whenever striking the same adversary.',
                'mastery_feature_name' => 'Primal Bond',
                'mastery_feature_description' => 'Share damage thresholds with your companion and fight together as a single unified force.',
            ],

            // Seraph Subclasses
            [
                'class_slug' => 'seraph',
                'name' => 'Winged Sentinel',
                'description' => 'A divine protector with magnificent angelic wings who swoops down to rescue comrades.',
                'spellcast_trait' => 'Presence',
                'foundation_feature_name' => 'Radiant Flight',
                'foundation_feature_description' => 'Fly above the battlefield and dive-bomb enemies with radiant warhammers or spears.',
                'specialization_feature_name' => 'Aegis of Dawn',
                'specialization_feature_description' => 'Erect a glowing barrier that deflects ranged spells and projectiles.',
                'mastery_feature_name' => 'Ascendant Seraph',
                'mastery_feature_description' => 'Emanate pure blinding radiance that burns enemies and heals party members every round.',
            ],
            [
                'class_slug' => 'seraph',
                'name' => 'Divine Wielder',
                'description' => 'A holy crusader who manifests weapons formed from pure condensed divine sunlight.',
                'spellcast_trait' => 'Strength',
                'foundation_feature_name' => 'Sunblade Manifestation',
                'foundation_feature_description' => 'Conjure a luminous weapon that deals radiant damage and sheds bright daylight.',
                'specialization_feature_name' => 'Smite the Wicked',
                'specialization_feature_description' => 'Spend 1 Hope on a hit to add +2d8 radiant smite damage.',
                'mastery_feature_name' => 'Avatar of Justice',
                'mastery_feature_description' => 'Execute divine judgment, banishing fiends or undead back to outer planes.',
            ],

            // Sorcerer Subclasses
            [
                'class_slug' => 'sorcerer',
                'name' => 'Elemental Origin',
                'description' => 'Commands raging elemental forces of wildfire, glacial ice, or storm lightning.',
                'spellcast_trait' => 'Instinct',
                'foundation_feature_name' => 'Elemental Affinity',
                'foundation_feature_description' => 'Choose your elemental affinity to gain resistance and extra spell damage in that element.',
                'specialization_feature_name' => 'Wildfire Surge',
                'specialization_feature_description' => 'Spells explode in a wider radius, setting terrain and enemies ablaze.',
                'mastery_feature_name' => 'Elemental Incarnate',
                'mastery_feature_description' => 'Transform entirely into pure living elemental fire or storm energy.',
            ],
            [
                'class_slug' => 'sorcerer',
                'name' => 'Primal Origin',
                'description' => 'Draws raw magical energy straight from ancient ley lines and cosmic rifts.',
                'spellcast_trait' => 'Presence',
                'foundation_feature_name' => 'Chaos Cascade',
                'foundation_feature_description' => 'Whenever you roll doubles on a spellcast, trigger a beneficial chaotic wild magic surge.',
                'specialization_feature_name' => 'Mana Leech',
                'specialization_feature_description' => 'Drain magical essence from enemy spellcasters to refill your own Hope pool.',
                'mastery_feature_name' => 'Cosmic Nexus',
                'mastery_feature_description' => 'Bend the weave of magic to cast multiple spells simultaneously.',
            ],

            // Wizard Subclasses
            [
                'class_slug' => 'wizard',
                'name' => 'School of Knowledge',
                'description' => 'Scholars of profound ancient arcana, historical secrets, and universal lore.',
                'spellcast_trait' => 'Knowledge',
                'foundation_feature_name' => 'Tome of Secrets',
                'foundation_feature_description' => 'Equip 1 additional domain card beyond your normal loadout limit.',
                'specialization_feature_name' => 'Analyze Weakness',
                'specialization_feature_description' => 'Identify enemy vulnerabilities, damage thresholds, and special abilities with a glance.',
                'mastery_feature_name' => 'Omniscience',
                'mastery_feature_description' => 'Cast any spell from the SRD domain card vault once without having it in your loadout.',
            ],
            [
                'class_slug' => 'wizard',
                'name' => 'School of War',
                'description' => 'Combat mages trained to deliver devastating tactical bombardment and survive frontline skirmishes.',
                'spellcast_trait' => 'Knowledge',
                'foundation_feature_name' => 'Arcane Armor',
                'foundation_feature_description' => 'Add your Knowledge modifier directly to your base Evasion or Armor score.',
                'specialization_feature_name' => 'Tactical Sculpting',
                'specialization_feature_description' => 'Shape area-of-effect spells so they never hit allies standing within the blast.',
                'mastery_feature_name' => 'Cataclysm',
                'mastery_feature_description' => 'Unleash an apocalyptic magical strike that deals massive severe damage across the entire battlefield.',
            ],
        ];

        foreach ($subclasses as $subclassData) {
            $class = CharacterClass::where('slug', $subclassData['class_slug'])->first();

            if (! $class) {
                continue;
            }

            Subclass::updateOrCreate(
                ['slug' => Str::slug($class->name.'-'.$subclassData['name'])],
                [
                    'character_class_id' => $class->id,
                    'name' => $subclassData['name'],
                    'description' => $subclassData['description'],
                    'spellcast_trait' => $subclassData['spellcast_trait'],
                    'foundation_feature_name' => $subclassData['foundation_feature_name'],
                    'foundation_feature_description' => $subclassData['foundation_feature_description'],
                    'specialization_feature_name' => $subclassData['specialization_feature_name'],
                    'specialization_feature_description' => $subclassData['specialization_feature_description'],
                    'mastery_feature_name' => $subclassData['mastery_feature_name'],
                    'mastery_feature_description' => $subclassData['mastery_feature_description'],
                    'is_srd' => true,
                    'is_public' => true,
                    'user_id' => null,
                ]
            );
        }
    }
}
