<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'id',
        'transaction_type',
        'recipient_account',
        'recipient_name',
        'sender_account',
        'sender_name',
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
            'model' => 'integer',
        ];
    }
}
