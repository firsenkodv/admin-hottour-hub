<?php

declare(strict_types=1);

namespace App\Http\Controllers\Identity;

use App\Http\Controllers\Controller;
use Domain\Identity\ViewModels\IdentityAccountViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class IdentityController extends Controller
{
    public function register(Request $request, IdentityAccountViewModel $accounts): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|email',
            'phone' => 'nullable|string|max:32',
            'password' => 'required|string|min:6',
        ]);

        if ($accounts->findByEmail($data['email'])) {
            throw ValidationException::withMessages([
                'email' => 'Учётная запись с таким email уже существует.',
            ]);
        }

        $account = $accounts->register($data['email'], $data['password'], $data['phone'] ?? null);

        return response()->json([
            'uuid' => $account->uuid,
            'email' => $account->email,
            'phone' => $account->phone,
        ], 201);
    }

    public function login(Request $request, IdentityAccountViewModel $accounts): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $account = $accounts->findByEmail($data['email']);

        if (!$account || !$accounts->verifyPassword($account, $data['password'])) {
            return response()->json(['message' => 'Неверный email или пароль.'], 401);
        }

        return response()->json([
            'uuid' => $account->uuid,
            'email' => $account->email,
            'phone' => $account->phone,
        ]);
    }

    public function forgotPassword(Request $request, IdentityAccountViewModel $accounts): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        $account = $accounts->findByEmail($data['email']);

        // Не раскрываем, существует ли аккаунт — отвечаем одинаково в обоих случаях.
        if ($account) {
            $token = $accounts->generateResetToken($account);

            Log::info('Identity: запрошен сброс пароля', [
                'email' => $account->email,
                'reset_token' => $token,
            ]);
        }

        return response()->json(['message' => 'Если аккаунт существует, инструкция отправлена.']);
    }

    public function resetPassword(Request $request, IdentityAccountViewModel $accounts): JsonResponse
    {
        $data = $request->validate([
            'token' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $account = $accounts->findByResetToken($data['token']);

        if (!$account) {
            return response()->json(['message' => 'Токен сброса недействителен или устарел.'], 422);
        }

        $accounts->resetPassword($account, $data['password']);

        return response()->json(['message' => 'Пароль обновлён.']);
    }
}
