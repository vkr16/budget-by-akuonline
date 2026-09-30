<?php

namespace App\Models;

use Database\Factories\PocketFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'name',
    'initial_balance',
    'current_balance',
    'color',
    'icon',
    'description',
    'is_active',
])]
class Pocket extends Model
{
    /** @use HasFactory<PocketFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'initial_balance' => 'decimal:2',
            'current_balance' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the owner of this pocket.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transactions for this pocket.
     *
     * @return HasMany<Transaction, $this>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Recalculate and update current balance based on initial balance and transactions.
     */
    public function recalculateBalance(): void
    {
        $totalIn = (float) $this->transactions()->where('type', 'in')->sum('amount');
        $totalOut = (float) $this->transactions()->where('type', 'out')->sum('amount');

        $this->update([
            'current_balance' => (float) $this->initial_balance + $totalIn - $totalOut,
        ]);
    }
}
