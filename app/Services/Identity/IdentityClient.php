<?php

declare(strict_types=1);

namespace App\Services\Identity;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class IdentityClient
{
    private string $baseUrl;

    private string $apiKey;

    private string $apiSecret;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) config('multisite.hub_base_url'), '/');
        $this->apiKey = (string) config('multisite.site_api_key');
        $this->apiSecret = (string) config('multisite.site_api_secret');
    }

    public function register(string $email, string $password, ?string $phone = null): Response
    {
        return $this->post('/identity/register', [
            'email' => $email,
            'password' => $password,
            'phone' => $phone,
        ]);
    }

    public function login(string $email, string $password): Response
    {
        return $this->post('/identity/login', [
            'email' => $email,
            'password' => $password,
        ]);
    }

    public function requestPasswordReset(string $email): Response
    {
        return $this->post('/identity/password/forgot', [
            'email' => $email,
        ]);
    }

    public function resetPassword(string $token, string $password): Response
    {
        return $this->post('/identity/password/reset', [
            'token' => $token,
            'password' => $password,
        ]);
    }

    private function post(string $path, array $payload): Response
    {
        $body = json_encode($payload, JSON_THROW_ON_ERROR);
        $signature = hash_hmac('sha256', $body, $this->apiSecret);

        return Http::withHeaders([
            'X-Site-Key' => $this->apiKey,
            'X-Site-Signature' => $signature,
            'Content-Type' => 'application/json',
        ])
            ->timeout(10)
            ->withBody($body, 'application/json')
            ->post("{$this->baseUrl}{$path}");
    }
}
