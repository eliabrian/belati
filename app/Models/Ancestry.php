<?php

namespace App\Models;

use Database\Factories\AncestryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'name',
    'slug',
    'description',
    'features',
    'is_srd',
    'is_public',
])]
class Ancestry extends Model
{
    /** @use HasFactory<AncestryFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'features' => 'array',
            'is_srd' => 'boolean',
            'is_public' => 'boolean',
        ];
    }

    /**
     * The creator of the homebrew ancestry (if any).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
