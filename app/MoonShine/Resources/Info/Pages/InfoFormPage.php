<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Info\Pages;

use App\Models\Site;
use App\MoonShine\Resources\Info\InfoResource;
use App\MoonShine\Resources\Site\SiteResource;
use Domain\Site\ViewModels\SiteViewModel;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends FormPage<InfoResource, \App\Models\Info>
 */
final class InfoFormPage extends FormPage
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

                        Text::make('Название', 'title')
                            ->required(),

                        Image::make('Изображение', 'image')
                            ->disk('public')
                            ->dir('info')
                            ->removable(),

                        Textarea::make('Краткое описание', 'smalltext'),

                        TinyMce::make('Полный текст', 'text'),
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
            'site_id' => [
                'required',
                'exists:sites,id',
                Rule::unique('infos', 'site_id')->ignore($item->getKey()),
            ],
            'title' => 'required|string|max:255',
        ];
    }
}
