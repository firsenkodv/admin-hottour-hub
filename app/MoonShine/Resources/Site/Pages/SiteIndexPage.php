<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Site\Pages;

use App\MoonShine\Resources\Site\SiteResource;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<SiteResource>
 */
final class SiteIndexPage extends IndexPage
{
    /**
     * @return list<\MoonShine\Contracts\UI\FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Код', 'code'),
            Text::make('Название', 'title'),
            Text::make('Домен', 'domain'),
            Switcher::make('Активен', 'is_active'),
            Date::make('Последняя синхронизация', 'last_synced_at')
                ->format('d.m.Y H:i')
                ->sortable(),
        ];
    }
}
