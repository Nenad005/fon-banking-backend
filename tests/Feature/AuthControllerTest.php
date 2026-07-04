<?php

namespace Tests\Feature;

use App\Models\ActivationCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_activation_code_is_accepted_when_submitted_with_surrounding_whitespace(): void
    {
        $user = User::create([
            'first_name' => 'Luka',
            'last_name' => 'Nenadovic',
            'jmbg' => '2410001583342',
            'phone_number' => '+381669442557',
            'email' => 'luka@example.com',
            'pin_hash' => null,
            'status' => 'pending_activation',
        ]);

        ActivationCode::create([
            'user_id' => $user->id,
            'code' => Hash::make('LUKA-2026'),
            'expires_at' => now()->addDay(),
        ]);

        $response = $this->postJson('/api/activate', [
            'code' => '  LUKA-2026  ',
        ]);

        $response->assertOk();
        $response->assertJsonPath('user_id', $user->id);
    }

    public function test_activation_code_is_accepted_when_stored_as_plain_text(): void
    {
        $user = User::create([
            'first_name' => 'Marko',
            'last_name' => 'Nenadovic',
            'jmbg' => '24100053783492',
            'phone_number' => '+381644546204',
            'email' => 'marko@example.com',
            'pin_hash' => null,
            'status' => 'pending_activation',
        ]);

        ActivationCode::create([
            'user_id' => $user->id,
            'code' => 'MARKO-2026',
            'expires_at' => now()->addDay(),
        ]);

        $response = $this->postJson('/api/activate', [
            'code' => 'MARKO-2026',
        ]);

        $response->assertOk();
        $response->assertJsonPath('user_id', $user->id);
    }
}
