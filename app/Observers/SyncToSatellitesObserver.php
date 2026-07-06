<?php

declare(strict_types=1);

namespace App\Observers;

use App\Jobs\SyncEntityToSiteJob;
use App\Models\Country;
use App\Models\CountrySiteContent;
use App\Models\Hotel;
use App\Models\Review;
use App\Models\Site;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class SyncToSatellitesObserver
{
    /**
     * @var array<class-string<Model>, array{entity: string, fields: string[]}>
     */
    private const SYNCABLE = [
        Hotel::class => [
            'entity' => 'hotels',
            'fields' => ['country_id', 'title', 'slug', 'stars', 'rating', 'smalltext', 'text', 'published', 'sorting', 'metatitle', 'description', 'keywords'],
        ],
        Review::class => [
            'entity' => 'reviews',
            'fields' => ['hotel_id', 'author_name', 'rating', 'text', 'published', 'sorting'],
        ],
    ];

    /**
     * Поля Country, которые может переопределить CountrySiteContent для конкретного сайта.
     * Пустое значение в переопределении = наследуется базовое поле Country.
     *
     * @var string[]
     */
    private const COUNTRY_CONTENT_FIELDS = ['title', 'smalltext', 'text', 'metatitle', 'description', 'keywords'];

    public function saved(Model $model): void
    {
        if ($model instanceof Country) {
            foreach (Site::query()->active()->get() as $site) {
                $this->dispatchCountrySync($model, $site);
            }

            return;
        }

        if ($model instanceof CountrySiteContent) {
            $this->syncCountrySiteContent($model);

            return;
        }

        $config = self::SYNCABLE[$model::class] ?? null;

        if (!$config) {
            return;
        }

        $payload = ['id' => $model->getKey(), ...Arr::only($model->toArray(), $config['fields'])];

        foreach (Site::query()->active()->get() as $site) {
            SyncEntityToSiteJob::dispatch($site, $config['entity'], $payload);
        }
    }

    public function deleted(Model $model): void
    {
        if ($model instanceof CountrySiteContent) {
            $this->syncCountrySiteContent($model);
        }
    }

    private function syncCountrySiteContent(CountrySiteContent $content): void
    {
        $country = $content->country()->first();
        $site = $content->site()->first();

        if (!$country || !$site || !$site->is_active) {
            return;
        }

        $this->dispatchCountrySync($country, $site);
    }

    private function dispatchCountrySync(Country $country, Site $site): void
    {
        $override = CountrySiteContent::query()
            ->where('country_id', $country->id)
            ->where('site_id', $site->id)
            ->first();

        $payload = [
            'id' => $country->id,
            'slug' => $country->slug,
            'published' => $country->published,
            'sorting' => $country->sorting,
        ];

        foreach (self::COUNTRY_CONTENT_FIELDS as $field) {
            $value = $override?->{$field};
            $payload[$field] = blank($value) ? $country->{$field} : $value;
        }

        SyncEntityToSiteJob::dispatch($site, 'countries', $payload);
    }
}
