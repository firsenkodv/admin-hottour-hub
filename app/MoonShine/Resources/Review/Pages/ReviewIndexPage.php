<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Review\Pages;

use App\Models\Hotel;
use App\MoonShine\Resources\Hotel\HotelResource;
use App\MoonShine\Resources\Review\ReviewResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<ReviewResource>
 */
final class ReviewIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Автор', 'author_name'),

            BelongsTo::make(
                'Отель',
                'hotel',
                formatted: static fn (Hotel $model) => $model->title,
                resource: HotelResource::class,
            ),

            Number::make('Рейтинг', 'rating'),
            Number::make('Сортировка', 'sorting'),
            Switcher::make('Опубликовано', 'published'),
        ];
    }
}
