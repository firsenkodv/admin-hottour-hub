<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Document\Pages;

use App\Models\Site;
use App\MoonShine\Resources\Document\DocumentResource;
use App\MoonShine\Resources\Site\SiteResource;
use Domain\Site\ViewModels\SiteViewModel;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends FormPage<DocumentResource, \App\Models\Document>
 */
final class DocumentFormPage extends FormPage
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
                    'Сайт',
                    'site',
                    formatted: static fn (Site $model) => $model->title,
                    resource: SiteResource::class,
                )
                    ->required()
                    ->default(SiteViewModel::make()->current()?->id)
                    ->valuesQuery(static fn (Builder $q) => $q->select(['id', 'title'])),

                Text::make('Название', 'title')
                    ->required()
                    ->unescape(),

                Slug::make('Slug', 'slug')
                    ->from('title')
                    ->unique()
                    ->locked(),

                File::make('Файл', 'file')
                    ->disk('public')
                    ->dir('documents')
                    ->removable()
                    ->required(),

                Textarea::make('Описание', 'description'),

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
            'site_id' => 'required|exists:sites,id',
            'title' => 'required|string|max:255',
        ];
    }
}
