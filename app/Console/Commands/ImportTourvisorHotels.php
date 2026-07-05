<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\Hotel;
use App\Services\Tourvisor\TourvisorClient;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Throwable;

class ImportTourvisorHotels extends Command
{
    protected $signature = 'tourvisor:import-hotels
        {--country=4 : Код страны Tourvisor (по умолчанию 4 — Турция)}
        {--limit=10 : Сколько отелей загрузить}';

    protected $description = 'Загружает отели из API Tourvisor (название и слаг) в локальную базу';

    public function handle(TourvisorClient $client): int
    {
        $countryCode = (int) $this->option('country');
        $limit = (int) $this->option('limit');

        $this->info("Запрашиваю список отелей Tourvisor для страны #{$countryCode}...");

        try {
            $hotelIds = $client->listHotelIds($countryCode);
        } catch (Throwable $e) {
            $this->error('Не удалось получить список отелей: ' . $e->getMessage());

            return self::FAILURE;
        }

        if ($hotelIds === []) {
            $this->warn('API Tourvisor вернул пустой список отелей для этой страны.');

            return self::FAILURE;
        }

        $hotelIds = array_slice($hotelIds, 0, $limit);
        $imported = 0;

        foreach ($hotelIds as $tourvisorId) {
            try {
                $data = $client->getHotel($tourvisorId);
            } catch (Throwable $e) {
                $this->warn("Отель #{$tourvisorId}: {$e->getMessage()}");

                continue;
            }

            $title = data_get($data, 'name');
            $countryName = data_get($data, 'country');

            if (!$title || !$countryName) {
                $this->warn("Отель #{$tourvisorId}: в ответе API нет названия или страны, пропускаю.");

                continue;
            }

            $country = Country::query()->firstOrCreate(
                ['slug' => Str::slug($countryName)],
                ['title' => $countryName, 'published' => true],
            );

            $slug = Str::slug($title);
            $existing = Hotel::query()->where('slug', $slug)->first();

            if ($existing && ($existing->title !== $title || $existing->country_id !== $country->id)) {
                $slug = "{$slug}-{$tourvisorId}";
            }

            Hotel::query()->updateOrCreate(
                ['slug' => $slug],
                ['title' => $title, 'country_id' => $country->id, 'published' => true],
            );

            $this->line("✓ {$title} ({$slug})");
            $imported++;
        }

        $this->info("Готово: загружено отелей — {$imported}");

        return self::SUCCESS;
    }
}
