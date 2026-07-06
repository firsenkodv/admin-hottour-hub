<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Identity\IdentityClient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Throwable;

class CustomerAuthController extends Controller
{
    public function showRegister(): View
    {
        return view('pages.auth.register');
    }

    public function register(Request $request, IdentityClient $identity): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $response = $identity->register($data['email'], $data['password']);
        } catch (Throwable $e) {
            return back()->withInput()->withErrors(['email' => 'Сервис регистрации временно недоступен. Попробуйте позже.']);
        }

        if ($response->status() === 422) {
            return back()->withInput()->withErrors(['email' => 'Аккаунт с таким email уже существует.']);
        }

        if (!$response->successful()) {
            return back()->withInput()->withErrors(['email' => 'Не удалось зарегистрироваться. Попробуйте позже.']);
        }

        $user = User::query()->create([
            'uuid' => $response->json('uuid'),
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function showLogin(): View
    {
        return view('pages.auth.login');
    }

    public function login(Request $request, IdentityClient $identity): RedirectResponse
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $response = $identity->login($data['email'], $data['password']);
        } catch (Throwable $e) {
            return back()->withInput()->withErrors(['email' => 'Сервис входа временно недоступен. Попробуйте позже.']);
        }

        if (!$response->successful()) {
            return back()->withInput()->withErrors(['email' => 'Неверный email или пароль.']);
        }

        $uuid = $response->json('uuid');

        $user = User::query()->firstOrCreate(
            ['uuid' => $uuid],
            ['name' => Str::before($data['email'], '@'), 'email' => $data['email']],
        );

        Auth::login($user);

        return redirect()->route('home');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function showForgotPassword(): View
    {
        return view('pages.auth.forgot-password');
    }

    public function sendResetLink(Request $request, IdentityClient $identity): RedirectResponse
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $identity->requestPasswordReset($data['email']);
        } catch (Throwable $e) {
            return back()->withErrors(['email' => 'Сервис временно недоступен. Попробуйте позже.']);
        }

        flash()->info('Если аккаунт существует, инструкция по сбросу пароля отправлена.');

        return back();
    }

    public function showResetForm(string $token): View
    {
        return view('pages.auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request, IdentityClient $identity): RedirectResponse
    {
        $data = $request->validate([
            'token' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $response = $identity->resetPassword($data['token'], $data['password']);
        } catch (Throwable $e) {
            return back()->withErrors(['password' => 'Сервис временно недоступен. Попробуйте позже.']);
        }

        if (!$response->successful()) {
            return back()->withErrors(['password' => 'Токен сброса недействителен или устарел.']);
        }

        flash()->info('Пароль обновлён, теперь можно войти.');

        return redirect()->route('login.show');
    }
}
