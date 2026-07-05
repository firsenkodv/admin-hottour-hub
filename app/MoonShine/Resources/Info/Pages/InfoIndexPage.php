<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Info\Pages;

use App\Models\Site;
use App\MoonShine\Resources\Info\InfoResource;
use App\MoonShine\Resources\Site\SiteResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<InfoResource>
 */
final class InfoIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make(
                'Сайт',
                'site',
                formatted: static fn (Site $model) => $model->title,
                resource: SiteResource::class,
            ),

            Text::make('Название', 'title'),
        ];
    }
}
