<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Travelitem\Pages;

use App\Models\Site;
use App\Models\Travelcategory;
use App\MoonShine\Resources\Site\SiteResource;
use App\MoonShine\Resources\Travelcategory\TravelcategoryResource;
use App\MoonShine\Resources\Travelitem\TravelitemResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<TravelitemResource>
 */
final class TravelitemIndexPage extends IndexPage
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
                'Категория',
                'travelcategory',
                formatted: static fn (Travelcategory $model) => $model->title,
                resource: TravelcategoryResource::class,
            ),

            Number::make('Сортировка', 'sorting'),
            Switcher::make('Опубликовано', 'published'),
        ];
    }
}
