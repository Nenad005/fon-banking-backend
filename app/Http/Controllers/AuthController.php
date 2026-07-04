<?php

namespace App\Http\Controllers;

use App\Models\ActivationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function activate(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $submittedCode = trim($request->input('code'));

        $activeCodes = ActivationCode::whereNull('used_at')
            ->where('expires_at', '>', now())
            ->get();

        $matchedCode = null;

        foreach ($activeCodes as $activationCode) {
            $isMatch = Hash::check($submittedCode, $activationCode->code);

            if ($isMatch) {
                $matchedCode = $activationCode;
                break;
            }
        }

        if (! $matchedCode) {
            return response()->json([
                'message' => 'Aktivacioni kod je nevalidan ili istekao.',
            ], 422);
        }

        $user = $matchedCode->user;

        // TODO: Treba promeniti status user-a i registrovati ili izmeniti uredjaj
        return response()->json([
            'message' => 'Kod je uspešno verifikovan.',
            'user_id' => $user->id,
        ]);
    }

    public function setup_pin(Request $request) {

    } 
}
