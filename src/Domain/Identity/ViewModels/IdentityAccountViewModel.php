<?php

namespace Domain\Identity\ViewModels;

use App\Models\IdentityAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Support\Traits\Makeable;

class IdentityAccountViewModel
{
    use Makeable;

    public function findByEmail(string $email): ?IdentityAccount
    {
        return IdentityAccount::query()->byEmail($email)->first();
    }

    public function register(string $email, string $password, ?string $phone = null): IdentityAccount
    {
        return IdentityAccount::query()->create([
            'uuid' => (string) Str::uuid(),
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
        ]);
    }

    public function verifyPassword(IdentityAccount $account, string $password): bool
    {
        return Hash::check($password, $account->password);
    }

    public function generateResetToken(IdentityAccount $account): string
    {
        $token = Str::random(64);

        $account->update([
            'reset_token' => $token,
            'reset_token_expires_at' => now()->addHour(),
        ]);

        return $token;
    }

    public function findByResetToken(string $token): ?IdentityAccount
    {
        return IdentityAccount::query()->byResetToken($token)->first();
    }

    public function resetPassword(IdentityAccount $account, string $password): void
    {
        $account->update([
            'password' => $password,
            'reset_token' => null,
            'reset_token_expires_at' => null,
        ]);
    }
}
