<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Site;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifySiteSignature
{
    /**
     * Проверяет, что запрос к hub-only Identity API пришёл от известного сайта
     * группы: заголовок X-Site-Key указывает на sites.api_key, а X-Site-Signature
     * должна быть HMAC-SHA256 тела запроса на sites.api_secret этого сайта.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = (string) $request->header('X-Site-Key');
        $signature = (string) $request->header('X-Site-Signature');

        if ($apiKey === '' || $signature === '') {
            abort(401, 'Отсутствуют заголовки авторизации сайта.');
        }

        $site = Site::query()->where('api_key', $apiKey)->where('is_active', true)->first();

        if (!$site) {
            abort(401, 'Неизвестный или неактивный сайт.');
        }

        $expected = hash_hmac('sha256', $request->getContent(), $site->api_secret);

        if (!hash_equals($expected, $signature)) {
            abort(401, 'Неверная подпись запроса.');
        }

        return $next($request);
    }
}
