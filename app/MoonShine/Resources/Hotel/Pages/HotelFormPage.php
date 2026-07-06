<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Hotel\Pages;

use App\Models\Country;
use App\Models\Hotel;
use App\MoonShine\Resources\Country\CountryResource;
use App\MoonShine\Resources\Hotel\HotelResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends FormPage<HotelResource, Hotel>
 */
final class HotelFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                Tabs::make([
                    Tab::make('Основное', [
                        ID::make(),

                        BelongsTo::make(
                            'Страна',
                            'country',
                            formatted: static fn (Country $model) => $model->title,
                            resource: CountryResource::class,
                        )
                            ->required()
                            ->valuesQuery(static fn (Builder $q) => $q->select(['id', 'title'])),

                        Text::make('Название', 'title')
                            ->required()
                            ->unescape(),

                        Slug::make('Slug', 'slug')
                            ->from('title')
                            ->unique()
                            ->locked(),

                        Number::make('Звёзды', 'stars')
                            ->min(1)
                            ->max(5),

                        Number::make('Рейтинг', 'rating')
                            ->step(0.1),

                        Image::make('Изображение', 'image')
                            ->disk('public')
                            ->dir('hotels')
                            ->removable(),

                        Image::make('Галерея', 'gallery')
                            ->disk('public')
                            ->dir('hotels/gallery')
                            ->multiple()
                            ->removable(),

                        Textarea::make('Краткое описание', 'smalltext'),

                        TinyMce::make('Полное описание', 'text'),

                        Number::make('Сортировка', 'sorting')
                            ->default(0),

                        Switcher::make('Опубликовано', 'published')
                            ->default(true),
                    ])->icon('document-text'),

                    Tab::make('SEO', [
                        Text::make('Meta Title', 'metatitle'),
                        Textarea::make('Description', 'description'),
                        Text::make('Keywords', 'keywords'),
                    ])->icon('magnifying-glass'),
                ]),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'country_id' => 'required|exists:countries,id',
            'title' => 'required|string|max:255',
            'stars' => 'nullable|integer|min:1|max:5',
            'rating' => 'nullable|numeric|min:0|max:10',
        ];
    }
}
