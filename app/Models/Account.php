<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    private const EXCHANGE_RATE = 117.2;

    protected $fillable = [
        'id',
        'account_id',
        'user_id',
        'title',
        'name',
        'color',
        'currency',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public static function convertAmount(float $amount, string $fromCurrency, string $toCurrency): float
    {
        if ($fromCurrency === $toCurrency) {
            return round($amount, 2);
        }

        return $fromCurrency === 'EUR'
            ? round($amount * self::EXCHANGE_RATE, 2)
            : round($amount / self::EXCHANGE_RATE, 2);
    }

    public static function exchangeRateBetween(string $fromCurrency, string $toCurrency): float
    {
        if ($fromCurrency === $toCurrency) {
            return 1.0;
        }

        return $fromCurrency === 'EUR'
            ? self::EXCHANGE_RATE
            : round(1 / self::EXCHANGE_RATE, 6);
    }

    protected function balance(): Attribute
    {
        return Attribute::get(function (): float {
            $incoming = $this->incomingTransactions()
                ->get()
                ->sum(fn (Transaction $transaction): float => $this->incomingAmount($transaction));

            $outgoing = $this->outgoingTransactions()
                ->get()
                ->sum(fn (Transaction $transaction): float => $this->outgoingAmount($transaction));

            return round($incoming - $outgoing, 2);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'account_id', 'id');
    }

    public function outgoingTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'sender_account', 'account_id');
    }

    public function incomingTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'recipient_account', 'account_id');
    }

    private function incomingAmount(Transaction $transaction): float
    {
        $amount = $transaction->recipient_amount ?? $transaction->amount;
        $currency = $transaction->recipient_currency ?? $transaction->currency;

        return self::convertAmount((float) $amount, $currency, $this->currency);
    }

    private function outgoingAmount(Transaction $transaction): float
    {
        $amount = $transaction->sender_amount ?? $transaction->amount;
        $currency = $transaction->sender_currency ?? $transaction->currency;

        return self::convertAmount((float) $amount, $currency, $this->currency);
    }
}
