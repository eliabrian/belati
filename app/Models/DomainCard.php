<?php

namespace App\Models;

use Database\Factories\DomainCardFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'domain',
    'name',
    'slug',
    'level',
    'type',
    'recall_cost',
    'description',
    'is_srd',
    'is_public',
])]
class DomainCard extends Model
{
    /** @use HasFactory<DomainCardFactory> */
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
            'recall_cost' => 'integer',
            'is_srd' => 'boolean',
            'is_public' => 'boolean',
        ];
    }

    /**
     * Scope a query to only include cards of a given domain.
     *
     * @param  Builder<DomainCard>  $query
     * @return Builder<DomainCard>
     */
    public function scopeForDomain(Builder $query, string $domain): Builder
    {
        return $query->where('domain', $domain);
    }

    /**
     * Scope a query to only include cards of a given level.
     *
     * @param  Builder<DomainCard>  $query
     * @return Builder<DomainCard>
     */
    public function scopeForLevel(Builder $query, int $level): Builder
    {
        return $query->where('level', $level);
    }

    /**
     * The author of the homebrew domain card (if any).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
