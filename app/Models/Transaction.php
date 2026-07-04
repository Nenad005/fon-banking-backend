<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_type',
        'recipient_account_id',
        'recipient_name',
        'sender_account_id',
        'model',
        'reference',
        'amount',
        'currency',
        'payment_purpose',
        'payment_code',
        'transaction_time',
        'status',
        'card_id',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'float',
            'transaction_time' => 'datetime',
        ];
    }

    public function sender() : HasOne
    {
        return $this->hasOne(Account::class, 'sender_account_id', 'id');
    }

    public function recipient() : HasOne
    {
        return $this->hasOne(Account::class, 'recipient_account_id', 'id');
    }
}
