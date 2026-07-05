<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Hottour\Pages;

use App\Models\Country;
use App\Models\Hotel;
use App\Models\Site;
use App\MoonShine\Resources\Country\CountryResource;
use App\MoonShine\Resources\Hotel\HotelResource;
use App\MoonShine\Resources\Hottour\HottourResource;
use App\MoonShine\Resources\Site\SiteResource;
use Domain\Site\ViewModels\SiteViewModel;
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
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends FormPage<HottourResource, \App\Models\Hottour>
 */
final class HottourFormPage extends FormPage
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
                            'Сайт',
                            'site',
                            formatted: static fn (Site $model) => $model->title,
                            resource: SiteResource::class,
                        )
                            ->required()
                            ->default(SiteViewModel::make()->current()?->id)
                            ->valuesQuery(static fn (Builder $q) => $q->select(['id', 'title'])),

                        BelongsTo::make(
                            'Страна',
                            'country',
                            formatted: static fn (Country $model) => $model->title,
                            resource: CountryResource::class,
                        )
                            ->required()
                            ->valuesQuery(static fn (Builder $q) => $q->select(['id', 'title'])),

                        BelongsTo::make(
                            'Отель',
                            'hotel',
                            formatted: static fn (Hotel $model) => $model->title,
                            resource: HotelResource::class,
                        )
                            ->nullable()
                            ->valuesQuery(static fn (Builder $q) => $q->select(['id', 'title'])),

                        Text::make('Название', 'title')
                            ->required(),

                        Slug::make('Slug', 'slug')
                            ->from('title')
                            ->live()
                            ->unique()
                            ->required(),

                        Number::make('Цена', 'price')
                            ->step('0.01')
                            ->required(),

                        Number::make('Старая цена', 'old_price')
                            ->step('0.01'),

                        Number::make('Ночей', 'nights'),

                        Date::make('Актуально до', 'valid_until'),

                        Image::make('Изображение', 'image')
                            ->disk('public')
                            ->dir('hottours')
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
            'site_id' => 'required|exists:sites,id',
            'country_id' => 'required|exists:countries,id',
            'hotel_id' => 'nullable|exists:hotels,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'nights' => 'nullable|integer|min:0',
            'valid_until' => 'nullable|date',
        ];
    }
}
