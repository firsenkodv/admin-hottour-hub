<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Country\Pages;

use App\Models\Country;
use App\Models\Site;
use App\MoonShine\Resources\Country\CountryResource;
use App\MoonShine\Resources\Country\CountrySiteContentResource;
use App\MoonShine\Resources\Site\SiteResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Support\ListOf;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends FormPage<CountryResource, Country>
 */
final class CountryFormPage extends FormPage
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

                        Text::make('Заголовок', 'title')->required()->unescape(),
                        Slug::make('Slug', 'slug')->from('title')->unique()->locked(),

                        Image::make('Изображение', 'image')
                            ->disk('public')
                            ->dir('countries')
                            ->removable(),

                        Textarea::make('Краткое описание', 'smalltext'),

                        TinyMce::make('Полное описание', 'text'),

                        Number::make('Сортировка', 'sorting')
                            ->default(0),

                        Switcher::make('Опубликовано', 'published')
                            ->default(true),
                    ])->icon('document-text'),

                    Tab::make('SEO', [
                        Grid::make([
                            Column::make([
                                Text::make('Meta Title', 'metatitle'),
                                Text::make('Description', 'description'),
                                Text::make('Keywords', 'keywords'),
                            ])->columnSpan(9),
                        ]),

                    ])->icon('magnifying-glass'),

                    // Страна как сущность (id, slug, картинка, факты) — общая для всей группы,
                    // но текст/SEO для неё может отличаться по сайтам (язык, маркетинг).
                    // Пустое поле здесь = наследуется базовый текст из вкладок выше.
                    // Существует и заполняется только на хабе.
                    ...(config('multisite.is_hub') ? [
                        Tab::make('По сайтам', [
                            Grid::make([
                                Column::make([

                            RelationRepeater::make('Контент по сайтам', 'siteContents', resource: CountrySiteContentResource::class)
                                ->fields([
                                    BelongsTo::make(
                                        'Сайт',
                                        'site',
                                        formatted: static fn(Site $model) => $model->title,
                                        resource: SiteResource::class,
                                    )
                                        ->required()
                                        ->valuesQuery(static fn(Builder $q) => $q->where('is_active', true)->select(['id', 'title'])),

                                    Text::make('Заголовок', 'title'),
                                    Textarea::make('Краткое описание', 'smalltext'),
                                    TinyMce::make('Полное описание', 'text'),
                                    Text::make('Meta Title', 'metatitle'),
                                    Text::make('Description', 'description'),
                                    Text::make('Keywords', 'keywords'),
                                ])
                                ->vertical()
                                ->creatable()
                                ->removable(),
                                ])->columnSpan(9),
                            ]),
                        ])->icon('language'),

                    ] : []),
                ]),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'title' => 'required|string|max:255',
        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    protected function formButtons(): ListOf
    {
        return parent::formButtons();
    }


    protected function modifyFormComponent(FormBuilderContract $component): FormBuilderContract
    {
        return $component;
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [...parent::topLayer()];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [...parent::mainLayer()];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [...parent::bottomLayer()];
    }
}
