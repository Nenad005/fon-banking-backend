<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'recipient_account',
        'recipient_name',
        'sender_account',
        'model',
        'reference_number',
        'amount',
        'currency',
        'payment_purpose',
        'payment_code',
        'transaction_time',
        'status',
        'card_number',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected function casts(): array
    {
        return [
            'amount' => 'float',
            'transaction_time' => 'datetime',
        ];
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'sender_account', 'account_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'recipient_account', 'account_id');
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'card_number', 'card_id');
    }
}
