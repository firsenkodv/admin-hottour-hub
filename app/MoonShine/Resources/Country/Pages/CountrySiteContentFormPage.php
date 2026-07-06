<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Country\Pages;

use App\Models\Site;
use App\MoonShine\Resources\Country\CountrySiteContentResource;
use App\MoonShine\Resources\Site\SiteResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends FormPage<CountrySiteContentResource, \App\Models\CountrySiteContent>
 */
final class CountrySiteContentFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),

            BelongsTo::make(
                'Сайт',
                'site',
                formatted: static fn (Site $model) => $model->title,
                resource: SiteResource::class,
            )
                ->required()
                ->valuesQuery(static fn (Builder $q) => $q->where('is_active', true)->select(['id', 'title'])),

            Text::make('Заголовок', 'title'),
            Textarea::make('Краткое описание', 'smalltext'),
            Textarea::make('Полное описание', 'text'),
            Text::make('Meta Title', 'metatitle'),
            Textarea::make('Description', 'description'),
            Text::make('Keywords', 'keywords'),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'site_id' => 'required|exists:sites,id',
        ];
    }
}
