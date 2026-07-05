<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Tour\Pages;

use App\Models\Country;
use App\Models\Site;
use App\MoonShine\Resources\Country\CountryResource;
use App\MoonShine\Resources\Site\SiteResource;
use App\MoonShine\Resources\Tour\TourResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<TourResource>
 */
final class TourIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'title'),

            BelongsTo::make(
                'Сайт',
                'site',
                formatted: static fn (Site $model) => $model->title,
                resource: SiteResource::class,
            ),

            BelongsTo::make(
                'Страна',
                'country',
                formatted: static fn (Country $model) => $model->title,
                resource: CountryResource::class,
            ),

            Number::make('Цена', 'price'),
            Number::make('Ночей', 'nights'),
            Number::make('Сортировка', 'sorting'),
            Switcher::make('Опубликовано', 'published'),
        ];
    }
}
