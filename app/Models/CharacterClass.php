<?php

namespace App\Models;

use Database\Factories\CharacterClassFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'name',
    'slug',
    'description',
    'primary_domains',
    'starting_evasion',
    'starting_hit_points',
    'starting_stress',
    'starting_hope',
    'base_major_threshold',
    'base_severe_threshold',
    'class_feature_name',
    'class_feature_description',
    'hope_feature_name',
    'hope_feature_description',
    'is_srd',
    'is_public',
])]
class CharacterClass extends Model
{
    /** @use HasFactory<CharacterClassFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'primary_domains' => 'array',
            'is_srd' => 'boolean',
            'is_public' => 'boolean',
            'starting_evasion' => 'integer',
            'starting_hit_points' => 'integer',
            'starting_stress' => 'integer',
            'starting_hope' => 'integer',
            'base_major_threshold' => 'integer',
            'base_severe_threshold' => 'integer',
        ];
    }

    /**
     * The creator of the homebrew class (if any).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Subclasses available under this class.
     */
    public function subclasses(): HasMany
    {
        return $this->hasMany(Subclass::class);
    }
}
