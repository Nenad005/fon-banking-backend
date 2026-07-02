<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index(): JsonResponse
    {
        $userId = Auth::id();

        $accounts = Account::query()
            ->where('user_id', $userId)
            ->get()
            ->map(function (Account $account): array {
                return [
                    'title' => $account->title,
                    'name' => $account->name,
                    'accountId' => $account->account_id,
                    'balance' => $account->balance,
                    'color' => $account->color,
                    'currency' => $account->currency,
                ];
            });

        return response()->json($accounts);
    }
}
