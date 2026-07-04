<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    protected $fillable = [
        'account_id',
        'card_id',
        'card_type',
        'expire_date',
        'owner_name',
        'currency',
        'cvv',
    ];

    public $incrementing = true;

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
