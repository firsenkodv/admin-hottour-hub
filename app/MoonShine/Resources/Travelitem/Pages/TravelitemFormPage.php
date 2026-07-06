<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Travelitem\Pages;

use App\Models\Site;
use App\Models\Travelcategory;
use App\MoonShine\Resources\Site\SiteResource;
use App\MoonShine\Resources\Travelcategory\TravelcategoryResource;
use App\MoonShine\Resources\Travelitem\TravelitemResource;
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
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends FormPage<TravelitemResource, \App\Models\Travelitem>
 */
final class TravelitemFormPage extends FormPage
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
                            'Категория',
                            'travelcategory',
                            formatted: static fn (Travelcategory $model) => $model->title,
                            resource: TravelcategoryResource::class,
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

                        Image::make('Изображение', 'image')
                            ->disk('public')
                            ->dir('travelitems')
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
            'travelcategory_id' => 'required|exists:travelcategories,id',
            'title' => 'required|string|max:255',
        ];
    }
}
