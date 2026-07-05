<?php

declare(strict_types=1);

namespace App\Services\Tourvisor;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class TourvisorClient
{
    private string $baseUrl;

    private string $login;

    private string $password;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) config('services.tourvisor.url'), '/');
        $this->login = (string) config('services.tourvisor.login');
        $this->password = (string) config('services.tourvisor.password');
    }

    /**
     * @return list<int> Список кодов отелей Tourvisor для страны.
     */
    public function listHotelIds(int $countryId): array
    {
        $response = Http::timeout(20)->get("{$this->baseUrl}/list.php", [
            ...$this->auth(),
            'type' => 'hotel',
            'hotcountry' => $countryId,
            'format' => 'json',
        ]);

        if (!$response->successful()) {
            throw new RuntimeException("Tourvisor list.php вернул HTTP {$response->status()}");
        }

        $hotels = data_get($response->json(), 'lists.hotels.hotel', []);

        return collect($hotels)
            ->pluck('id')
            ->filter()
            ->map(static fn ($id) => (int) $id)
            ->values()
            ->all();
    }

    /**
     * @return array<string, mixed>|null Данные отеля (data.hotel из ответа API).
     */
    public function getHotel(int $hotelId): ?array
    {
        $response = Http::timeout(20)->get("{$this->baseUrl}/hotel.php", [
            ...$this->auth(),
            'hotelcode' => $hotelId,
            'format' => 'json',
        ]);

        if (!$response->successful()) {
            throw new RuntimeException("Tourvisor hotel.php вернул HTTP {$response->status()} для отеля #{$hotelId}");
        }

        return data_get($response->json(), 'data.hotel');
    }

    /**
     * @return array<string, string>
     */
    private function auth(): array
    {
        return [
            'authlogin' => $this->login,
            'authpass' => $this->password,
        ];
    }
}
