<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends Model
{
    protected $fillable = [
        'id',
        'account_id',
        'card_id',
        'card_type',
        'expire_date',
        'owner_name',
        'currency',
        'cvv',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'card_number', 'card_id');
    }
}
