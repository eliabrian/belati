<?php

namespace App\Models;

use Database\Factories\CharacterFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
    'user_id',
    'character_class_id',
    'subclass_id',
    'ancestry_id',
    'community_id',
    'name',
    'pronouns',
    'level',
    'agility',
    'strength',
    'finesse',
    'instinct',
    'presence',
    'knowledge',
    'hit_points_current',
    'hit_points_max',
    'stress_current',
    'stress_max',
    'hope_current',
    'hope_max',
    'armor_score',
    'armor_slots_current',
    'armor_slots_max',
    'evasion',
    'major_threshold',
    'severe_threshold',
    'gold',
    'background',
    'notes',
    'is_public',
])]
class Character extends Model
{
    /** @use HasFactory<CharacterFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'level' => 'integer',
            'agility' => 'integer',
            'strength' => 'integer',
            'finesse' => 'integer',
            'instinct' => 'integer',
            'presence' => 'integer',
            'knowledge' => 'integer',
            'hit_points_current' => 'integer',
            'hit_points_max' => 'integer',
            'stress_current' => 'integer',
            'stress_max' => 'integer',
            'hope_current' => 'integer',
            'hope_max' => 'integer',
            'armor_score' => 'integer',
            'armor_slots_current' => 'integer',
            'armor_slots_max' => 'integer',
            'evasion' => 'integer',
            'major_threshold' => 'integer',
            'severe_threshold' => 'integer',
            'gold' => 'integer',
            'is_public' => 'boolean',
        ];
    }

    /**
     * The owner of this character (if authenticated).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The character's chosen class.
     */
    public function characterClass(): BelongsTo
    {
        return $this->belongsTo(CharacterClass::class);
    }

    /**
     * The character's chosen subclass.
     */
    public function subclass(): BelongsTo
    {
        return $this->belongsTo(Subclass::class);
    }

    /**
     * The character's chosen ancestry.
     */
    public function ancestry(): BelongsTo
    {
        return $this->belongsTo(Ancestry::class);
    }

    /**
     * The character's chosen community.
     */
    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    /**
     * All domain cards in loadout or vault.
     */
    public function domainCards(): BelongsToMany
    {
        return $this->belongsToMany(DomainCard::class, 'character_domain_cards')
            ->withPivot('is_equipped')
            ->withTimestamps();
    }

    /**
     * Currently active equipped domain cards (loadout).
     */
    public function equippedDomainCards(): BelongsToMany
    {
        return $this->domainCards()->wherePivot('is_equipped', true);
    }

    /**
     * Domain cards stored in vault.
     */
    public function vaultDomainCards(): BelongsToMany
    {
        return $this->domainCards()->wherePivot('is_equipped', false);
    }
}
