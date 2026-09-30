<?php

namespace App\Models;

use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'pocket_id',
    'type',
    'amount',
    'date',
    'description',
])]
class Transaction extends Model
{
    /** @use HasFactory<TransactionFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'date' => 'datetime',
        ];
    }

    /**
     * Get the user who owns this transaction.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the pocket associated with this transaction.
     *
     * @return BelongsTo<Pocket, $this>
     */
    public function pocket(): BelongsTo
    {
        return $this->belongsTo(Pocket::class);
    }

    /**
     * Scope query to only incoming transactions.
     *
     * @param  Builder<Transaction>  $query
     */
    public function scopeIn(Builder $query): Builder
    {
        return $query->where('type', 'in');
    }

    /**
     * Scope query to only outgoing transactions.
     *
     * @param  Builder<Transaction>  $query
     */
    public function scopeOut(Builder $query): Builder
    {
        return $query->where('type', 'out');
    }
}
