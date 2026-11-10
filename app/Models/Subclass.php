<?php

namespace App\Models;

use Database\Factories\SubclassFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'character_class_id',
    'user_id',
    'name',
    'slug',
    'description',
    'spellcast_trait',
    'foundation_feature_name',
    'foundation_feature_description',
    'specialization_feature_name',
    'specialization_feature_description',
    'mastery_feature_name',
    'mastery_feature_description',
    'is_srd',
    'is_public',
])]
class Subclass extends Model
{
    /** @use HasFactory<SubclassFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_srd' => 'boolean',
            'is_public' => 'boolean',
        ];
    }

    /**
     * The parent character class.
     */
    public function characterClass(): BelongsTo
    {
        return $this->belongsTo(CharacterClass::class);
    }

    /**
     * The creator of the homebrew subclass (if any).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
