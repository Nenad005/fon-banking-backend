<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'name',
        'account_id',
        'balance',
        'color',
        'currency',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected function casts(): array
    {
        return [
            'balance' => 'float',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'account_id', 'id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'sender_account', 'account_id');
    }
}
