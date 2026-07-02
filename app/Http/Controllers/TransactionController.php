<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'senderAccount' => ['required', 'string'],
            'recipientAccount' => ['required', 'string'],
            'recipientName' => ['required', 'string'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency' => ['required', 'string'],
            'paymentPurpose' => ['nullable', 'string'],
            'paymentCode' => ['nullable', 'string'],
            'model' => ['nullable', 'integer'],
            'referenceNumber' => ['nullable', 'string'],
        ]);

        $account = Account::query()
            ->where('account_id', $validated['senderAccount'])
            ->where('user_id', $userId)
            ->firstOrFail();

        if ($account->balance < $validated['amount']) {
            return response()->json([
                'message' => 'Insufficient funds.',
            ], 422);
        }

        $account->balance -= (float) $validated['amount'];
        $account->save();

        $transaction = Transaction::create([
            'id' => 'txn-'.Str::upper(Str::random(4)),
            'transaction_type' => 'odliv',
            'recipient_account' => $validated['recipientAccount'],
            'recipient_name' => $validated['recipientName'],
            'sender_account' => $validated['senderAccount'],
            'sender_name' => $account->name,
            'model' => $validated['model'] ?? null,
            'reference_number' => $validated['referenceNumber'] ?? null,
            'amount' => (float) $validated['amount'],
            'currency' => $validated['currency'],
            'payment_purpose' => $validated['paymentPurpose'] ?? null,
            'payment_code' => $validated['paymentCode'] ?? null,
            'transaction_time' => now(),
            'status' => 'na_cekanju',
            'card_number' => null,
        ]);

        return response()->json([
            'id' => $transaction->id,
            'transactionType' => $transaction->transaction_type,
            'recipientAccount' => $transaction->recipient_account,
            'recipientName' => $transaction->recipient_name,
            'senderAccount' => $transaction->sender_account,
            'senderName' => $transaction->sender_name,
            'model' => $transaction->model,
            'referenceNumber' => $transaction->reference_number,
            'amount' => $transaction->amount,
            'currency' => $transaction->currency,
            'paymentPurpose' => $transaction->payment_purpose,
            'paymentCode' => $transaction->payment_code,
            'transactionTime' => $transaction->transaction_time?->toISOString(),
            'status' => $transaction->status,
            'cardNumber' => $transaction->card_number,
        ], 201);
    }

    public function index(string $accountId): JsonResponse
    {
        $userId = Auth::id();

        $account = Account::query()
            ->where('account_id', $accountId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $transactions = Transaction::query()
            ->where(function ($query) use ($accountId): void {
                $query->where('sender_account', $accountId)
                    ->orWhere('recipient_account', $accountId);
            })
            ->latest('transaction_time')
            ->get()
            ->map(function (Transaction $transaction): array {
                return [
                    'id' => $transaction->id,
                    'transactionType' => $transaction->transaction_type,
                    'recipientAccount' => $transaction->recipient_account,
                    'recipientName' => $transaction->recipient_name,
                    'senderAccount' => $transaction->sender_account,
                    'senderName' => $transaction->sender_name,
                    'model' => $transaction->model,
                    'referenceNumber' => $transaction->reference_number,
                    'amount' => $transaction->amount,
                    'currency' => $transaction->currency,
                    'paymentPurpose' => $transaction->payment_purpose,
                    'paymentCode' => $transaction->payment_code,
                    'transactionTime' => $transaction->transaction_time?->toISOString(),
                    'status' => $transaction->status,
                    'cardNumber' => $transaction->card_number,
                ];
            });

        return response()->json($transactions);
    }
}
