<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyHubSignature
{
    /**
     * Проверяет, что push от hub'а (Этап 4 — content-sync) подписан секретом
     * ЭТОГО сайта (config('multisite.site_api_secret')) — тем же самым, что
     * этот сайт использует для собственных вызовов к Identity API (Этап 3).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $signature = (string) $request->header('X-Site-Signature');
        $secret = (string) config('multisite.site_api_secret');

        if ($signature === '' || $secret === '') {
            abort(401, 'Отсутствует подпись запроса или секрет сайта не настроен.');
        }

        $expected = hash_hmac('sha256', $request->getContent(), $secret);

        if (!hash_equals($expected, $signature)) {
            abort(401, 'Неверная подпись запроса.');
        }

        return $next($request);
    }
}
