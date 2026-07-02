<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Card;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function index(string $accountId): JsonResponse
    {
        $userId = Auth::id();

        $account = Account::query()
            ->where('account_id', $accountId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $cards = Card::query()
            ->where('account_id', $account->id)
            ->get()
            ->map(function (Card $card): array {
                return [
                    'accountId' => $card->account->account_id,
                    'cardId' => $card->card_id,
                    'cardType' => $card->card_type,
                    'expireDate' => $card->expire_date,
                    'ownerName' => $card->owner_name,
                    'currency' => $card->currency,
                    'cvv' => $card->cvv,
                ];
            });

        return response()->json($cards);
    }
}
