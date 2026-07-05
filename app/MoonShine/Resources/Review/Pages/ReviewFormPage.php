<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Review\Pages;

use App\Models\Hotel;
use App\MoonShine\Resources\Hotel\HotelResource;
use App\MoonShine\Resources\Review\ReviewResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends FormPage<ReviewResource, \App\Models\Review>
 */
final class ReviewFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                ID::make(),

                BelongsTo::make(
                    'Отель',
                    'hotel',
                    formatted: static fn (Hotel $model) => $model->title,
                    resource: HotelResource::class,
                )
                    ->nullable()
                    ->valuesQuery(static fn (Builder $q) => $q->select(['id', 'title'])),

                Text::make('Автор', 'author_name')
                    ->required(),

                Number::make('Рейтинг', 'rating')
                    ->min(1)
                    ->max(5),

                Textarea::make('Текст отзыва', 'text')
                    ->required(),

                Number::make('Сортировка', 'sorting')
                    ->default(0),

                Switcher::make('Опубликовано', 'published')
                    ->default(true),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'hotel_id' => 'nullable|exists:hotels,id',
            'author_name' => 'required|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'text' => 'required|string',
        ];
    }
}
