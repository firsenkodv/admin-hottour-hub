<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Country\Pages;

use App\MoonShine\Resources\Country\CountrySiteContentResource;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<CountrySiteContentResource>
 */
final class CountrySiteContentIndexPage extends IndexPage
{
    /**
     * @return list<\MoonShine\Contracts\UI\FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Заголовок', 'title'),
        ];
    }
}
